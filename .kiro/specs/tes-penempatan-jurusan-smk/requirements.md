# Requirements Document

## Introduction

Sistem Tes Kemampuan Dasar & Penempatan Jurusan SMK adalah aplikasi berbasis web yang dirancang untuk mengukur kemampuan dasar calon siswa baru dan memberikan rekomendasi penempatan jurusan secara otomatis berdasarkan hasil tes. Sistem ini menggunakan algoritma penilaian berbobot untuk menentukan jurusan yang paling sesuai dengan kemampuan dan minat siswa.

## Glossary

- **System**: Sistem Tes Kemampuan Dasar & Penempatan Jurusan SMK
- **Admin**: Pengguna dengan hak akses penuh untuk mengelola sistem
- **Student**: Calon siswa baru yang mengikuti tes kemampuan dasar
- **Test**: Ujian kemampuan dasar yang terdiri dari berbagai kategori soal
- **Category**: Kelompok soal berdasarkan jenis kemampuan (Matematika, Logika, Teknik, Minat)
- **Major**: Jurusan yang tersedia (TKJ, TKR, TSM)
- **Weighted_Score**: Nilai yang dihitung berdasarkan bobot kategori untuk setiap jurusan
- **Recommendation**: Saran penempatan jurusan berdasarkan skor tertinggi
- **Question**: Soal tes dengan pilihan ganda (A-E)
- **Test_Session**: Sesi tes yang sedang berlangsung dengan timer

## Requirements

### Requirement 1: User Authentication

**User Story:** As a user (Admin or Student), I want to securely log in to the system, so that I can access features according to my role.

#### Acceptance Criteria

1. WHEN a user submits valid credentials, THE System SHALL authenticate the user and redirect to the appropriate dashboard
2. WHEN a user submits invalid credentials, THE System SHALL display an error message and prevent access
3. WHEN a Student registers for the first time, THE System SHALL create a new account with Student role
4. THE System SHALL hash all passwords using bcrypt before storing them
5. THE System SHALL implement CSRF protection on all authentication forms
6. WHEN a user logs out, THE System SHALL terminate the session and redirect to the login page

### Requirement 2: Student Registration

**User Story:** As a prospective student, I want to register for an account, so that I can take the placement test.

#### Acceptance Criteria

1. WHEN a Student provides name, email, password, NISN, and school origin, THE System SHALL create a new Student account
2. WHEN a Student submits a duplicate email or NISN, THE System SHALL reject the registration and display an error message
3. THE System SHALL validate that NISN contains only numeric characters
4. THE System SHALL require password minimum length of 8 characters
5. WHEN registration is successful, THE System SHALL redirect the Student to the login page

### Requirement 3: Test Category Management

**User Story:** As an Admin, I want to manage test categories with weighted scoring, so that different majors can have different evaluation criteria.

#### Acceptance Criteria

1. WHEN an Admin creates a Category, THE System SHALL store the category name and weight values for each Major
2. THE System SHALL support categories: Matematika Dasar, Logika, Kemampuan Teknik, and Minat & Bakat
3. WHEN an Admin updates Category weights, THE System SHALL recalculate all existing test recommendations
4. THE System SHALL validate that weight values are between 0 and 100
5. WHEN an Admin deletes a Category that has associated Questions, THE System SHALL prevent deletion and display an error

### Requirement 4: Question Management

**User Story:** As an Admin, I want to create and manage test questions, so that I can build a comprehensive assessment.

#### Acceptance Criteria

1. WHEN an Admin creates a Question, THE System SHALL store the question text, five options (A-E), correct answer, category, and point value
2. THE System SHALL validate that the correct answer is one of the provided options
3. WHEN an Admin updates a Question, THE System SHALL preserve existing student answers but use new scoring for future tests
4. WHEN an Admin deletes a Question, THE System SHALL remove it from future tests but preserve historical test data
5. THE System SHALL support rich text formatting in question text

### Requirement 5: Major Management

**User Story:** As an Admin, I want to manage available majors, so that the system can recommend appropriate programs.

#### Acceptance Criteria

1. THE System SHALL support three Majors: TKJ, TKR, and TSM
2. WHEN an Admin creates a Major, THE System SHALL store the major name and description
3. WHEN an Admin deactivates a Major, THE System SHALL exclude it from new recommendations but preserve historical data
4. THE System SHALL prevent deletion of Majors that have existing recommendations

### Requirement 6: Test Execution

**User Story:** As a Student, I want to take the placement test, so that I can receive a major recommendation.

#### Acceptance Criteria

1. WHEN a Student starts a Test, THE System SHALL randomly select questions from all active Categories
2. WHEN a Test is in progress, THE System SHALL display a countdown timer
3. WHEN the timer reaches zero, THE System SHALL automatically submit the Test
4. THE System SHALL allow Students to navigate between questions during the Test
5. WHEN a Student submits an answer, THE System SHALL save it immediately
6. THE System SHALL prevent Students from taking the Test more than once
7. WHEN a Student completes the Test, THE System SHALL calculate scores and generate recommendations

### Requirement 7: Scoring Algorithm

**User Story:** As the System, I want to calculate weighted scores for each major, so that I can provide accurate recommendations.

#### Acceptance Criteria

1. WHEN calculating scores, THE System SHALL compute the percentage score for each Category
2. FOR each Major, THE System SHALL calculate Weighted_Score as the sum of (Category_Score × Category_Weight)
3. THE System SHALL use the following weights for TKJ: 40% Logika, 30% Matematika, 30% Minat TKJ
4. THE System SHALL use the following weights for TKR: 50% Teknik, 30% Matematika, 20% Logika
5. THE System SHALL use the following weights for TSM: 50% Teknik, 30% Minat TSM, 20% Logika
6. WHEN all Weighted_Scores are calculated, THE System SHALL identify the Major with the highest score as the primary Recommendation
7. IF the difference between the highest and second-highest score is less than 5 points, THE System SHALL mark the second Major as an alternative Recommendation

### Requirement 8: Test Results Display

**User Story:** As a Student, I want to view my test results and recommendations, so that I understand my placement.

#### Acceptance Criteria

1. WHEN a Student views results, THE System SHALL display scores for each Category
2. THE System SHALL display the calculated Weighted_Score for each Major
3. THE System SHALL highlight the primary recommended Major
4. IF an alternative Recommendation exists, THE System SHALL display it with an "Alternative" label
5. THE System SHALL display a bar chart comparing Weighted_Scores across all Majors
6. THE System SHALL provide a PDF export option for the results

### Requirement 9: Admin Dashboard

**User Story:** As an Admin, I want to view system statistics, so that I can monitor test activity and results.

#### Acceptance Criteria

1. WHEN an Admin accesses the dashboard, THE System SHALL display the total number of Students
2. THE System SHALL display the total number of completed Tests
3. THE System SHALL display a pie chart showing the distribution of recommended Majors
4. THE System SHALL display a list of recent Tests with Student names and recommendations
5. THE System SHALL allow filtering statistics by date range

### Requirement 10: Results Export

**User Story:** As an Admin, I want to export test results, so that I can share data with school administration.

#### Acceptance Criteria

1. WHEN an Admin requests a PDF export, THE System SHALL generate a document containing all test results
2. WHEN an Admin requests an Excel export, THE System SHALL generate a spreadsheet with Student data, scores, and recommendations
3. THE System SHALL include Student name, NISN, test date, category scores, and recommended Major in exports
4. THE System SHALL allow filtering export data by date range and Major

### Requirement 11: Role-Based Access Control

**User Story:** As the System, I want to enforce role-based permissions, so that users can only access authorized features.

#### Acceptance Criteria

1. WHEN a Student attempts to access Admin routes, THE System SHALL deny access and redirect to the Student dashboard
2. WHEN an Admin attempts to take a Test, THE System SHALL deny access
3. THE System SHALL protect all Admin routes with authentication and role verification middleware
4. THE System SHALL protect all Student routes with authentication middleware

### Requirement 12: Test Session Management

**User Story:** As a Student, I want my test progress to be saved, so that I can resume if disconnected.

#### Acceptance Criteria

1. WHEN a Student answers a question, THE System SHALL immediately save the answer to the database
2. IF a Student's session is interrupted, THE System SHALL restore the Test_Session when they log back in
3. WHEN a Test_Session is restored, THE System SHALL resume the timer from the remaining time
4. THE System SHALL prevent Students from starting a new Test if an incomplete Test_Session exists

### Requirement 13: Data Validation

**User Story:** As the System, I want to validate all user inputs, so that data integrity is maintained.

#### Acceptance Criteria

1. THE System SHALL validate that all required fields are provided before processing forms
2. THE System SHALL sanitize all text inputs to prevent XSS attacks
3. THE System SHALL validate that numeric fields contain only valid numbers
4. THE System SHALL validate that email addresses follow standard email format
5. WHEN validation fails, THE System SHALL display specific error messages for each field

### Requirement 14: Question Randomization

**User Story:** As an Admin, I want questions to be randomized for each student, so that test integrity is maintained.

#### Acceptance Criteria

1. WHEN a Student starts a Test, THE System SHALL randomly order all Questions
2. WHEN a Student starts a Test, THE System SHALL randomly order the answer options for each Question
3. THE System SHALL ensure that each Student receives the same number of questions per Category
4. THE System SHALL store the randomization seed with the Test for reproducibility

### Requirement 15: Security Measures

**User Story:** As the System, I want to implement security best practices, so that user data is protected.

#### Acceptance Criteria

1. THE System SHALL implement CSRF protection on all forms
2. THE System SHALL use HTTPS for all communications in production
3. THE System SHALL implement rate limiting on login attempts
4. WHEN a user fails login 5 times, THE System SHALL temporarily lock the account for 15 minutes
5. THE System SHALL log all authentication attempts for security auditing
6. THE System SHALL sanitize all database queries to prevent SQL injection

### Requirement 16: Responsive Design

**User Story:** As a user, I want the system to work on mobile devices, so that I can access it from any device.

#### Acceptance Criteria

1. THE System SHALL display correctly on screen sizes from 320px to 1920px width
2. WHEN accessed on mobile, THE System SHALL provide touch-friendly navigation
3. THE System SHALL optimize images and assets for mobile bandwidth
4. WHEN taking a Test on mobile, THE System SHALL provide a fullscreen mode option
