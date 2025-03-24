const ResumeList = ({ resumes }) => {
  return (
    <div>
      <h2>Ranked Resumes</h2>
      <ul>
        {resumes.map((resume, index) => (
          <li key={index}>
            <strong>{resume.filename}</strong>: Score {resume.score}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default ResumeList;
