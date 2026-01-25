import { useEffect, useState } from 'react'
import './App.css'

function App() {
    const [courses, setCourses] = useState([])
    const [loading, setLoading] = useState(true)
    const [error, setError] = useState(null)

    useEffect(() => {
        fetch('http://localhost:10003/wp-json/my-lms/v1/courses')
            .then((res) => {
                if (!res.ok) {
                    throw new Error('Failed to fetch courses')
                }
                return res.json()
            })
            .then((data) => {
                // console.log(data)
                // assuming Response::success() returns { success, data }
                setCourses(data.data ?? [])
            })
            .catch((err) => {
                setError(err.message)
            })
            .finally(() => {
                setLoading(false)
            })
    }, [])

    if (loading) return <p>Loading courses...</p>
    if (error) return <p>Error: {error}</p>

    return (
        <div style={{ padding: '20px' }}>
            <h1>Courses</h1>

            {courses.length === 0 && <p>No courses found.</p>}

            <ul>
                {courses.map((course) => (
                    <li key={course.id}>
                        <strong>{course.title}</strong>
                        <p>{course.description}</p>
                        <small>Price: ${course.price}</small>
                    </li>
                ))}
            </ul>
        </div>
    )
}

export default App
