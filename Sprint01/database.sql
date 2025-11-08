

CREATE DATABASE IF NOT EXISTS zerothree
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_general_ci;
USE zerothree;

DROP TRIGGER IF EXISTS bu_user_accounts;
DROP TABLE IF EXISTS csr_reps;
DROP TABLE IF EXISTS user_admins;
DROP TABLE IF EXISTS platform_managers;
DROP TABLE IF EXISTS pins;
DROP TABLE IF EXISTS user_accounts;


CREATE TABLE user_accounts (
  userid               INT AUTO_INCREMENT PRIMARY KEY,
  full_name            VARCHAR(120) NOT NULL,
  email                VARCHAR(190) NOT NULL UNIQUE,
  password             VARCHAR(255) NOT NULL,  -- per project spec: NOT hashed (demo)
  phone_number         VARCHAR(40)  NULL,
  address              VARCHAR(255) NULL,
  user_profiles        ENUM('User Admin','PIN','Platform Manager','CSR Rep','Unassigned') NOT NULL DEFAULT 'Unassigned',
  user_account_status  ENUM('ACTIVE','SUSPENDED') NOT NULL DEFAULT 'ACTIVE',
  created_at           DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at           DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE pins (
  pin_id        INT AUTO_INCREMENT PRIMARY KEY,
  userid        INT NOT NULL UNIQUE,
  case_ref      VARCHAR(64)  NULL,
  needs_desc    TEXT         NULL,
  CONSTRAINT fk_pins_user
    FOREIGN KEY (userid) REFERENCES user_accounts(userid)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE platform_managers (
  platform_manager_id INT AUTO_INCREMENT PRIMARY KEY,
  userid              INT NOT NULL UNIQUE,
  department          VARCHAR(120) NULL,
  reports_scope       TEXT         NULL,
  CONSTRAINT fk_pm_user
    FOREIGN KEY (userid) REFERENCES user_accounts(userid)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE user_admins (
  user_admin_id INT AUTO_INCREMENT PRIMARY KEY,
  userid        INT NOT NULL UNIQUE,
  admin_notes   TEXT NULL,
  CONSTRAINT fk_admin_user
    FOREIGN KEY (userid) REFERENCES user_accounts(userid)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE csr_reps (
  csr_rep_id   INT AUTO_INCREMENT PRIMARY KEY,
  userid       INT NOT NULL UNIQUE,
  org_name     VARCHAR(120) NULL,
  org_contact  VARCHAR(120) NULL,
  CONSTRAINT fk_csr_user
    FOREIGN KEY (userid) REFERENCES user_accounts(userid)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DELIMITER $$
CREATE TRIGGER bu_user_accounts
BEFORE UPDATE ON user_accounts
FOR EACH ROW
BEGIN
  IF NEW.user_profiles <> OLD.user_profiles THEN
    IF EXISTS (SELECT 1 FROM pins WHERE userid = OLD.userid) THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot change role: remove old PIN extension first';
    END IF;
    IF EXISTS (SELECT 1 FROM csr_reps WHERE userid = OLD.userid) THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot change role: remove old CSR Rep extension first';
    END IF;
    IF EXISTS (SELECT 1 FROM platform_managers WHERE userid = OLD.userid) THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot change role: remove old Platform Manager extension first';
    END IF;
    IF EXISTS (SELECT 1 FROM user_admins WHERE userid = OLD.userid) THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot change role: remove old User Admin extension first';
    END IF;
  END IF;
END $$
DELIMITER ;
-------------------------
DELIMITER $$
CREATE PROCEDURE seed_users_100()
BEGIN
  DECLARE n INT DEFAULT 1;
  WHILE n <= 100 DO
    INSERT INTO user_accounts
      (full_name, email, password, phone_number, address, user_profiles, user_account_status)
    VALUES
      (CONCAT('User ', n),
       CONCAT('user', n, '@gmail.com'),
       CONCAT('user', n),                                  -- not hashed
       CONCAT('+65 8', LPAD(n,4,'0'), LPAD(n,3,'0')),
       CONCAT('Blk ', n, ' Demo St, Singapore'),
       CASE n % 5
         WHEN 0 THEN 'Unassigned'
         WHEN 1 THEN 'User Admin'
         WHEN 2 THEN 'PIN'
         WHEN 3 THEN 'Platform Manager'
         ELSE 'CSR Rep'
       END,
       IF(n % 7 = 0, 'SUSPENDED', 'ACTIVE')
      );
    SET n = n + 1;
  END WHILE;
END $$
DELIMITER ;

CALL seed_users_100();
DROP PROCEDURE seed_users_100;


-- User Admins
INSERT INTO user_admins (userid, admin_notes)
SELECT u.userid, CONCAT('Notes for admin #', u.userid)
FROM user_accounts u
LEFT JOIN user_admins a ON a.userid = u.userid
WHERE u.user_profiles = 'User Admin' AND a.userid IS NULL;

-- PINs
INSERT INTO pins (userid, case_ref, needs_desc)
SELECT u.userid,
       CONCAT('CASE', LPAD(u.userid, 4, '0')),
       CONCAT('Auto-seeded need description for PIN #', u.userid)
FROM user_accounts u
LEFT JOIN pins p ON p.userid = u.userid
WHERE u.user_profiles = 'PIN' AND p.userid IS NULL;

-- Platform Managers
INSERT INTO platform_managers (userid, department, reports_scope)
SELECT u.userid,
       CASE (u.userid % 3)
         WHEN 0 THEN 'Operations'
         WHEN 1 THEN 'IT'
         ELSE 'Compliance'
       END,
       CONCAT('Auto-seeded scope for manager #', u.userid)
FROM user_accounts u
LEFT JOIN platform_managers m ON m.userid = u.userid
WHERE u.user_profiles = 'Platform Manager' AND m.userid IS NULL;

-- CSR Reps
INSERT INTO csr_reps (userid, org_name, org_contact)
SELECT u.userid,
       CONCAT('Org ', u.userid),
       CONCAT('contact', u.userid, '@example.com')
FROM user_accounts u
LEFT JOIN csr_reps c ON c.userid = u.userid
WHERE u.user_profiles = 'CSR Rep' AND c.userid IS NULL;


