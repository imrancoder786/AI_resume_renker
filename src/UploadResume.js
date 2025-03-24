import React, { useState } from "react";
import axios from "axios";

const UploadResume = () => {
  const [selectedFile, setSelectedFile] = useState(null);
  const [message, setMessage] = useState("");

  const handleFileChange = (event) => {
    setSelectedFile(event.target.files[0]);
  };

  const handleUpload = async () => {
    if (!selectedFile) {
      setMessage("Please select a file!");
      return;
    }

    const formData = new FormData();
    formData.append("resume", selectedFile);

    try {
      const response = await axios.post("http://localhost:8000/index.php", formData, {
        headers: { "Content-Type": "multipart/form-data" },
      });
      setMessage(response.data.success || response.data.error);
    } catch (error) {
      setMessage("Upload failed.");
    }
  };

  return (
    <div>
      <input type="file" accept=".pdf" onChange={handleFileChange} />
      <button onClick={handleUpload}>Upload</button>
      <p>{message}</p>
    </div>
  );
};

export default UploadResume;
