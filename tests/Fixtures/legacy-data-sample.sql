-- Sample legacy dump for importer tests
INSERT INTO `users` (`_id`, `__v`, `createdAt`, `driverLicense`, `drivingExperience`, `email`, `fullname`, `otpCode`, `otpExpiresAt`, `password`, `phone`, `role`, `updatedAt`) VALUES
('owner-1', 0, '2025-10-01 08:00:00', '', '', 'owner@example.com', 'Owner One', NULL, NULL, '$2b$12$abcdefghijklmnopqrstuuY4L1xM6Y8f44sD7ML6wOe7iG4D4Qn2', '+250788000001', 'user', '2025-10-01 08:00:00'),
('buyer-1', 0, '2025-10-02 09:00:00', '', '', 'buyer@example.com', 'Buyer One', NULL, NULL, '$2b$12$abcdefghijklmnopqrstuuY4L1xM6Y8f44sD7ML6wOe7iG4D4Qn2', '+250788000002', 'user', '2025-10-02 09:00:00');

INSERT INTO `cars` (`_id`, `__v`, `bodyType`, `color`, `createdAt`, `description`, `fuelType`, `location`, `make`, `mileage`, `model`, `owner`, `price`, `primaryImage`, `reservedBy`, `reservedUntil`, `status`, `transmission`, `updatedAt`, `year`) VALUES
('car-1', 0, 'SUV', 'Black', '2025-10-03 10:00:00', '', 'petrol', 'Kigali, Kabeza', 'Toyota', 120000, 'RAV4', 'owner-1', 21500000, 'https://example.com/car-1-main.jpg', NULL, NULL, 'listed', 'automatic', '2025-10-03 11:00:00', 2018);

INSERT INTO `car_images` (`car_id`, `position`, `image_url`) VALUES
('car-1', 0, 'https://example.com/car-1-main.jpg'),
('car-1', 1, 'https://example.com/car-1-side.jpg');

INSERT INTO `bookings` (`_id`, `__v`, `car`, `createdAt`, `expiresAt`, `notes`, `status`, `updatedAt`, `user`) VALUES
('booking-1', 0, 'car-1', '2025-10-04 09:15:00', '2025-10-05 09:15:00', 'Need a viewing slot', 'pending', '2025-10-04 09:15:00', 'buyer-1');

INSERT INTO `wishlists` (`_id`, `__v`, `createdAt`, `updatedAt`, `user`) VALUES
('wishlist-1', 0, '2025-10-04 12:00:00', '2025-10-04 12:00:00', 'buyer-1');

INSERT INTO `wishlist_cars` (`wishlist_id`, `position`, `car_id`) VALUES
('wishlist-1', 0, 'car-1');
