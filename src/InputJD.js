import React, { useState } from "react";
import axios from "axios";

const InputJD = ({ setResumes }) => {
  const [jd, setJD] = useState("");

  const handleSubmit = async () => {
    console.log("Analyze button clicked!");
    console.log("Job Description:", jd);

    const response = await axios.post("http://localhost:8000/backend/index.php", { job_description: jd });
    console.log("API Response:", response.data);

    setResumes(response.data);
  };

  return (
    <div>
      <textarea placeholder="Enter Job Description" onChange={(e) => setJD(e.target.value)} />
      <button onClick={handleSubmit}>Analyze</button>
    </div>
  );
};

export default InputJD;
