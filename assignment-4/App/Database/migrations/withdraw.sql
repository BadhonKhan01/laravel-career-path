DROP TABLE IF EXISTS `withdraw`;
CREATE TABLE withdraw (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id bigint(20) UNSIGNED,
    status VARCHAR(255),
    amount DECIMAL(10, 2),
    setTransferBy VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `users` (`user_id`),
    FOREIGN KEY (`user_id`) REFERENCES users(`id`) ON DELETE CASCADE
);