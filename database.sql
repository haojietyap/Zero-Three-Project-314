
-- drop and create database (optional)
DROP DATABASE IF EXISTS zerothree;
CREATE DATABASE zerothree CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE zerothree;


-- 1. user profiles (roles)

CREATE TABLE user_profiles (
    profile_id      INT AUTO_INCREMENT PRIMARY KEY,
    profile_name    VARCHAR(50) NOT NULL UNIQUE,
    description     VARCHAR(255) NULL
) ENGINE=InnoDB;

INSERT INTO user_profiles (profile_name, description) VALUES
('User Admin',        'Manages user accounts and profiles'),
('PIN',               'Person-in-Need who requests assistance'),
('CSR Representative','Corporate volunteer representative'),
('Platform Manager',  'Manages categories and reports');


-- 2. users (accounts + important data) – 100 records

CREATE TABLE users (
    user_id        INT AUTO_INCREMENT PRIMARY KEY,
    profile_id     INT NOT NULL,
    username       VARCHAR(50) NOT NULL UNIQUE,
    password_hash  VARCHAR(255) NOT NULL,
    email          VARCHAR(100) NOT NULL UNIQUE,
    phone          VARCHAR(20) NULL,
    status         ENUM('ACTIVE','SUSPENDED') NOT NULL DEFAULT 'ACTIVE',
    created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    last_login_at  DATETIME NULL,
    CONSTRAINT fk_users_profile
        FOREIGN KEY (profile_id) REFERENCES user_profiles(profile_id)
) ENGINE=InnoDB;

INSERT INTO users (profile_id, username, password_hash, email, phone, status) VALUES
-- 10 user admins (user_id 1–10)
(1, 'admin01', 'admin01pass', 'admin01@example.com', '80000001', 'ACTIVE'),
(1, 'admin02', 'admin02pass', 'admin02@example.com', '80000002', 'ACTIVE'),
(1, 'admin03', 'admin03pass', 'admin03@example.com', '80000003', 'ACTIVE'),
(1, 'admin04', 'admin04pass', 'admin04@example.com', '80000004', 'ACTIVE'),
(1, 'admin05', 'admin05pass', 'admin05@example.com', '80000005', 'ACTIVE'),
(1, 'admin06', 'admin06pass', 'admin06@example.com', '80000006', 'ACTIVE'),
(1, 'admin07', 'admin07pass', 'admin07@example.com', '80000007', 'ACTIVE'),
(1, 'admin08', 'admin08pass', 'admin08@example.com', '80000008', 'ACTIVE'),
(1, 'admin09', 'admin09pass', 'admin09@example.com', '80000009', 'ACTIVE'),
(1, 'admin10', 'admin10pass', 'admin10@example.com', '80000010', 'ACTIVE'),

-- 30 PINs (user_id 11–40)
(2, 'pin01', 'pin01pass', 'pin01@example.com', '80000011', 'ACTIVE'),
(2, 'pin02', 'pin02pass', 'pin02@example.com', '80000012', 'ACTIVE'),
(2, 'pin03', 'pin03pass', 'pin03@example.com', '80000013', 'ACTIVE'),
(2, 'pin04', 'pin04pass', 'pin04@example.com', '80000014', 'ACTIVE'),
(2, 'pin05', 'pin05pass', 'pin05@example.com', '80000015', 'ACTIVE'),
(2, 'pin06', 'pin06pass', 'pin06@example.com', '80000016', 'ACTIVE'),
(2, 'pin07', 'pin07pass', 'pin07@example.com', '80000017', 'ACTIVE'),
(2, 'pin08', 'pin08pass', 'pin08@example.com', '80000018', 'ACTIVE'),
(2, 'pin09', 'pin09pass', 'pin09@example.com', '80000019', 'ACTIVE'),
(2, 'pin10', 'pin10pass', 'pin10@example.com', '80000020', 'ACTIVE'),
(2, 'pin11', 'pin11pass', 'pin11@example.com', '80000021', 'ACTIVE'),
(2, 'pin12', 'pin12pass', 'pin12@example.com', '80000022', 'ACTIVE'),
(2, 'pin13', 'pin13pass', 'pin13@example.com', '80000023', 'ACTIVE'),
(2, 'pin14', 'pin14pass', 'pin14@example.com', '80000024', 'ACTIVE'),
(2, 'pin15', 'pin15pass', 'pin15@example.com', '80000025', 'ACTIVE'),
(2, 'pin16', 'pin16pass', 'pin16@example.com', '80000026', 'ACTIVE'),
(2, 'pin17', 'pin17pass', 'pin17@example.com', '80000027', 'ACTIVE'),
(2, 'pin18', 'pin18pass', 'pin18@example.com', '80000028', 'ACTIVE'),
(2, 'pin19', 'pin19pass', 'pin19@example.com', '80000029', 'ACTIVE'),
(2, 'pin20', 'pin20pass', 'pin20@example.com', '80000030', 'ACTIVE'),
(2, 'pin21', 'pin21pass', 'pin21@example.com', '80000031', 'ACTIVE'),
(2, 'pin22', 'pin22pass', 'pin22@example.com', '80000032', 'ACTIVE'),
(2, 'pin23', 'pin23pass', 'pin23@example.com', '80000033', 'ACTIVE'),
(2, 'pin24', 'pin24pass', 'pin24@example.com', '80000034', 'ACTIVE'),
(2, 'pin25', 'pin25pass', 'pin25@example.com', '80000035', 'ACTIVE'),
(2, 'pin26', 'pin26pass', 'pin26@example.com', '80000036', 'ACTIVE'),
(2, 'pin27', 'pin27pass', 'pin27@example.com', '80000037', 'ACTIVE'),
(2, 'pin28', 'pin28pass', 'pin28@example.com', '80000038', 'ACTIVE'),
(2, 'pin29', 'pin29pass', 'pin29@example.com', '80000039', 'ACTIVE'),
(2, 'pin30', 'pin30pass', 'pin30@example.com', '80000040', 'ACTIVE'),

-- 40 CSR Reps (user_id 41–80)
(3, 'csr01', 'csr01pass', 'csr01@example.com', '80000041', 'ACTIVE'),
(3, 'csr02', 'csr02pass', 'csr02@example.com', '80000042', 'ACTIVE'),
(3, 'csr03', 'csr03pass', 'csr03@example.com', '80000043', 'ACTIVE'),
(3, 'csr04', 'csr04pass', 'csr04@example.com', '80000044', 'ACTIVE'),
(3, 'csr05', 'csr05pass', 'csr05@example.com', '80000045', 'ACTIVE'),
(3, 'csr06', 'csr06pass', 'csr06@example.com', '80000046', 'ACTIVE'),
(3, 'csr07', 'csr07pass', 'csr07@example.com', '80000047', 'ACTIVE'),
(3, 'csr08', 'csr08pass', 'csr08@example.com', '80000048', 'ACTIVE'),
(3, 'csr09', 'csr09pass', 'csr09@example.com', '80000049', 'ACTIVE'),
(3, 'csr10', 'csr10pass', 'csr10@example.com', '80000050', 'ACTIVE'),
(3, 'csr11', 'csr11pass', 'csr11@example.com', '80000051', 'ACTIVE'),
(3, 'csr12', 'csr12pass', 'csr12@example.com', '80000052', 'ACTIVE'),
(3, 'csr13', 'csr13pass', 'csr13@example.com', '80000053', 'ACTIVE'),
(3, 'csr14', 'csr14pass', 'csr14@example.com', '80000054', 'ACTIVE'),
(3, 'csr15', 'csr15pass', 'csr15@example.com', '80000055', 'ACTIVE'),
(3, 'csr16', 'csr16pass', 'csr16@example.com', '80000056', 'ACTIVE'),
(3, 'csr17', 'csr17pass', 'csr17@example.com', '80000057', 'ACTIVE'),
(3, 'csr18', 'csr18pass', 'csr18@example.com', '80000058', 'ACTIVE'),
(3, 'csr19', 'csr19pass', 'csr19@example.com', '80000059', 'ACTIVE'),
(3, 'csr20', 'csr20pass', 'csr20@example.com', '80000060', 'ACTIVE'),
(3, 'csr21', 'csr21pass', 'csr21@example.com', '80000061', 'ACTIVE'),
(3, 'csr22', 'csr22pass', 'csr22@example.com', '80000062', 'ACTIVE'),
(3, 'csr23', 'csr23pass', 'csr23@example.com', '80000063', 'ACTIVE'),
(3, 'csr24', 'csr24pass', 'csr24@example.com', '80000064', 'ACTIVE'),
(3, 'csr25', 'csr25pass', 'csr25@example.com', '80000065', 'ACTIVE'),
(3, 'csr26', 'csr26pass', 'csr26@example.com', '80000066', 'ACTIVE'),
(3, 'csr27', 'csr27pass', 'csr27@example.com', '80000067', 'ACTIVE'),
(3, 'csr28', 'csr28pass', 'csr28@example.com', '80000068', 'ACTIVE'),
(3, 'csr29', 'csr29pass', 'csr29@example.com', '80000069', 'ACTIVE'),
(3, 'csr30', 'csr30pass', 'csr30@example.com', '80000070', 'ACTIVE'),
(3, 'csr31', 'csr31pass', 'csr31@example.com', '80000071', 'ACTIVE'),
(3, 'csr32', 'csr32pass', 'csr32@example.com', '80000072', 'ACTIVE'),
(3, 'csr33', 'csr33pass', 'csr33@example.com', '80000073', 'ACTIVE'),
(3, 'csr34', 'csr34pass', 'csr34@example.com', '80000074', 'ACTIVE'),
(3, 'csr35', 'csr35pass', 'csr35@example.com', '80000075', 'ACTIVE'),
(3, 'csr36', 'csr36pass', 'csr36@example.com', '80000076', 'ACTIVE'),
(3, 'csr37', 'csr37pass', 'csr37@example.com', '80000077', 'ACTIVE'),
(3, 'csr38', 'csr38pass', 'csr38@example.com', '80000078', 'ACTIVE'),
(3, 'csr39', 'csr39pass', 'csr39@example.com', '80000079', 'ACTIVE'),
(3, 'csr40', 'csr40pass', 'csr40@example.com', '80000080', 'ACTIVE'),

-- 20 platform managers (user_id 81–100)
(4, 'pm01', 'pm01pass', 'pm01@example.com', '80000081', 'ACTIVE'),
(4, 'pm02', 'pm02pass', 'pm02@example.com', '80000082', 'ACTIVE'),
(4, 'pm03', 'pm03pass', 'pm03@example.com', '80000083', 'ACTIVE'),
(4, 'pm04', 'pm04pass', 'pm04@example.com', '80000084', 'ACTIVE'),
(4, 'pm05', 'pm05pass', 'pm05@example.com', '80000085', 'ACTIVE'),
(4, 'pm06', 'pm06pass', 'pm06@example.com', '80000086', 'ACTIVE'),
(4, 'pm07', 'pm07pass', 'pm07@example.com', '80000087', 'ACTIVE'),
(4, 'pm08', 'pm08pass', 'pm08@example.com', '80000088', 'ACTIVE'),
(4, 'pm09', 'pm09pass', 'pm09@example.com', '80000089', 'ACTIVE'),
(4, 'pm10', 'pm10pass', 'pm10@example.com', '80000090', 'ACTIVE'),
(4, 'pm11', 'pm11pass', 'pm11@example.com', '80000091', 'ACTIVE'),
(4, 'pm12', 'pm12pass', 'pm12@example.com', '80000092', 'ACTIVE'),
(4, 'pm13', 'pm13pass', 'pm13@example.com', '80000093', 'ACTIVE'),
(4, 'pm14', 'pm14pass', 'pm14@example.com', '80000094', 'ACTIVE'),
(4, 'pm15', 'pm15pass', 'pm15@example.com', '80000095', 'ACTIVE'),
(4, 'pm16', 'pm16pass', 'pm16@example.com', '80000096', 'ACTIVE'),
(4, 'pm17', 'pm17pass', 'pm17@example.com', '80000097', 'ACTIVE'),
(4, 'pm18', 'pm18pass', 'pm18@example.com', '80000098', 'ACTIVE'),
(4, 'pm19', 'pm19pass', 'pm19@example.com', '80000099', 'ACTIVE'),
(4, 'pm20', 'pm20pass', 'pm20@example.com', '80000100', 'ACTIVE');


-- 3. user details (extra info per user)

CREATE TABLE user_details (
    detail_id      INT AUTO_INCREMENT PRIMARY KEY,
    user_id        INT NOT NULL UNIQUE,
    first_name     VARCHAR(50) NOT NULL,
    last_name      VARCHAR(50) NOT NULL,
    gender         ENUM('M','F','OTHER') NULL,
    address_line1  VARCHAR(100) NULL,
    address_line2  VARCHAR(100) NULL,
    city           VARCHAR(50) NULL,
    country        VARCHAR(50) NULL,
    organisation   VARCHAR(100) NULL,
    position_title VARCHAR(100) NULL,
    CONSTRAINT fk_details_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
) ENGINE=InnoDB;

-- just sample details for a few users (you can expand later)
INSERT INTO user_details
(user_id, first_name, last_name, gender, address_line1, city, country, organisation, position_title)
VALUES
(1,  'Alice',  'Tan',  'F', '123 Admin St',  'Singapore', 'Singapore', NULL,            'User Admin'),
(11, 'Peter',  'Lim',  'M', '45 Pine Rd',    'Singapore', 'Singapore', NULL,            'PIN'),
(12, 'Mary',   'Ho',   'F', '9 Maple Ave',   'Singapore', 'Singapore', NULL,            'PIN'),
(41, 'Chris',  'Low',  'M', '88 CSR Lane',   'Singapore', 'Singapore', 'Company A',     'CSR Rep'),
(42, 'Diana',  'Lee',  'F', '12 Volunteer',  'Singapore', 'Singapore', 'Company B',     'CSR Rep'),
(81, 'Samuel', 'Lau',  'M', '77 Manager Rd', 'Singapore', 'Singapore', 'Platform Org',  'Platform Manager');


-- 4. service categories (Platform Manager feature)

CREATE TABLE service_categories (
    category_id    INT AUTO_INCREMENT PRIMARY KEY,
    category_name  VARCHAR(100) NOT NULL UNIQUE,
    description    VARCHAR(255) NULL,
    is_active      TINYINT(1) NOT NULL DEFAULT 1,
    created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO service_categories (category_name, description) VALUES
('Food Distribution',      'Deliver meals to families in need'),
('Elderly Care',           'Assist seniors with daily activities'),
('Education Support',      'Tutoring and mentoring students'),
('Environmental Cleanup',  'Clean public areas and parks'),
('Healthcare Aid',         'Support medical/health events');


-- 5. requests (PIN creates help requests)
--    using PIN user_ids in 11–40

CREATE TABLE requests (
    request_id       INT AUTO_INCREMENT PRIMARY KEY,
    pin_user_id      INT NOT NULL,
    category_id      INT NOT NULL,
    title            VARCHAR(100) NOT NULL,
    description      TEXT NOT NULL,
    location         VARCHAR(150) NULL,
    preferred_date   DATE NULL,
    status           ENUM('OPEN','CONFIRMED','COMPLETED','CANCELLED')
                        NOT NULL DEFAULT 'OPEN',
    view_count       INT NOT NULL DEFAULT 0,
    shortlist_count  INT NOT NULL DEFAULT 0,
    created_at       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at       DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_requests_pin
        FOREIGN KEY (pin_user_id) REFERENCES users(user_id),
    CONSTRAINT fk_requests_category
        FOREIGN KEY (category_id) REFERENCES service_categories(category_id)
) ENGINE=InnoDB;

INSERT INTO requests
(pin_user_id, category_id, title, description, location, preferred_date, status, view_count, shortlist_count)
VALUES
(11, 1, 'Weekly Meal Delivery',
    'Need volunteers to deliver cooked meals to my block.',
    'Bedok', '2025-11-20', 'OPEN',        5, 1),
(11, 2, 'Escort to Clinic',
    'Require help to go to clinic appointment.',
    'Tampines', '2025-11-18', 'CONFIRMED', 10, 2),
(12, 3, 'Homework Coaching',
    'Need tutor for primary school math.',
    'Hougang', '2025-11-25', 'OPEN',       3, 0),
(13, 4, 'Park Cleanup Event',
    'Looking for volunteers to clean local park.',
    'Pasir Ris Park', '2025-12-02', 'COMPLETED', 20, 4),
(14, 5, 'Health Screening Support',
    'Help with registration at health screening event.',
    'Yishun CC', '2025-11-30', 'OPEN',     2, 1);


-- 6. request shortlist (CSR saves favourite opportunities)
--    using CSR user_ids in 41–80

CREATE TABLE request_shortlists (
    shortlist_id   INT AUTO_INCREMENT PRIMARY KEY,
    csr_user_id    INT NOT NULL,
    request_id     INT NOT NULL,
    shortlisted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_csr_request (csr_user_id, request_id),
    CONSTRAINT fk_shortlist_csr
        FOREIGN KEY (csr_user_id) REFERENCES users(user_id),
    CONSTRAINT fk_shortlist_request
        FOREIGN KEY (request_id) REFERENCES requests(request_id)
) ENGINE=InnoDB;

INSERT INTO request_shortlists (csr_user_id, request_id) VALUES
(41, 1),
(41, 2),
(42, 2),
(42, 4);


-- 7. matches (confirmed / completed services)
--    PIN in 11–40, CSR in 41–80

CREATE TABLE matches (
    match_id     INT AUTO_INCREMENT PRIMARY KEY,
    request_id   INT NOT NULL,
    pin_user_id  INT NOT NULL,
    csr_user_id  INT NOT NULL,
    service_date DATE NOT NULL,
    status       ENUM('CONFIRMED','COMPLETED','CANCELLED')
                    NOT NULL DEFAULT 'CONFIRMED',
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    completed_at DATETIME NULL,
    CONSTRAINT fk_matches_request
        FOREIGN KEY (request_id) REFERENCES requests(request_id),
    CONSTRAINT fk_matches_pin
        FOREIGN KEY (pin_user_id) REFERENCES users(user_id),
    CONSTRAINT fk_matches_csr
        FOREIGN KEY (csr_user_id) REFERENCES users(user_id)
) ENGINE=InnoDB;

INSERT INTO matches
(request_id, pin_user_id, csr_user_id, service_date, status, completed_at)
VALUES
(2, 11, 41, '2025-11-18', 'COMPLETED', '2025-11-18'),
(4, 13, 42, '2025-11-05', 'COMPLETED', '2025-11-05');


-- 8. login audit (optional logging of login/logout)

CREATE TABLE login_audit (
    audit_id    INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL,
    action      ENUM('LOGIN','LOGOUT') NOT NULL,
    action_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ip_address  VARCHAR(45) NULL,
    CONSTRAINT fk_audit_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
) ENGINE=InnoDB;

INSERT INTO login_audit (user_id, action, ip_address) VALUES
(1,  'LOGIN',  '127.0.0.1'),
(1,  'LOGOUT', '127.0.0.1'),
(11, 'LOGIN',  '127.0.0.1');
