CREATE TABLE users (
    user_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE image (
    file_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    paths VARCHAR(100) NOT NULL,
    file_name VARCHAR(100) NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

INSERT INTO users (user_name, email) VALUES ('John Doe', 'john@example.com');

INSERT INTO image (paths, file_name, user_id) VALUES
('./asset/picture/cat.jpg', 'cat', 1);
