import React, { useState } from "react";
import UploadResume from "./UploadResume";
import InputJD from "./InputJD";
import ResumeList from "./ResumeList";

const App = () => {
  const [resumes, setResumes] = useState([]);

  return (
    <div>
      <h1>AI Resume Shortlisting</h1>
      <UploadResume />
      <InputJD setResumes={setResumes} />
      <ResumeList resumes={resumes} />
    </div>
  );
};

export default App;
