INSERT INTO users (email,name,password_hash,role,is_active) VALUES
('admin@familyoffice.local','Admin', '$2y$10$QKTy5E0R8gk1sS6O9bU5UO5d1DkQ8fFz0pnyM6Yx9xVdE3uR6m4a6','ADMIN',1)
ON DUPLICATE KEY UPDATE email=email;

INSERT INTO settings (id,company_name) VALUES (1,'Family Office') ON DUPLICATE KEY UPDATE id=id;