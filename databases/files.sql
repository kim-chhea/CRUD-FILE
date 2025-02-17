CREATE TABLE Files (
    File_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Name_file VARCHAR(100) NOT NULL,
    display_name VARCHAR(100) NOT NULL
);

INSERT INTO Files (Name_file, display_name) VALUES
('PIC_TEXT1', 'PIC-1'),
('PIC_TEXT2', 'PIC-2');
