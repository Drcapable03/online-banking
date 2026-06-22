INSERT IGNORE INTO tbl_account (account_no, username, password)
VALUES (338509629, 'admin_pool', '$2y$10$pkvn6vvA8BgA4jbqhaUsSO/64/sr9Iqu9JJvQ5sXjYAwVNocK3WlW');

INSERT IGNORE INTO tbl_customer (account_no, full_name, gender, birth_date, mobile, email, primary_currency)
VALUES (338509629, 'Bank Operations', 'M', '2000-01-01', '0000000000', 'operations@bank.local', 'USD');

INSERT IGNORE INTO tbl_address (account_no, home_address, city, state, pincode)
VALUES (338509629, 'Operations Desk', 'New York', 'NY', 10001);

INSERT IGNORE INTO tbl_account_type (account_no, account_type)
VALUES (338509629, 'SAVING');

INSERT IGNORE INTO tbl_balance (account_no, account_type, balance)
VALUES (338509629, 'SAVING', 0);

UPDATE tbl_balance SET balance = 5000 WHERE account_no = 338509634 AND balance = 0;