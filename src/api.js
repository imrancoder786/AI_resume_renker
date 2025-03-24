import axios from "axios";

const instance = axios.create({
    baseURL: "http://localhost/resume-shortlist/",  // Change if needed
    headers: {
        "Content-Type": "multipart/form-data",
    },
});

export default instance;
