INSERT INTO users (requistration_id, document_id, document_type, name, email, type, active, passwd, administrator_id) 
VALUES ('admin000', '00000000X', 'DNI', 'Root Admin', 'root@autoquiray.com', 'administrator', 1, 'rootpass123', NULL);

INSERT INTO administrators (requistration_id, salary) 
VALUES ('admin000', 2000.00);