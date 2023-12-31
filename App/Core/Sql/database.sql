CREATE TABLE `mois`
(
    `id` int(12) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `mois` varchar(50) NOT NULL
);

CREATE TABLE `prestations` (
    `id` int(12) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `prestation` varchar(50) NOT NULL
);

CREATE TABLE `Entreprise` (
    `id` int (12) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nom_de_chantier` varchar(50) NOT NULL,
    `code_du_chantier` varchar(50) NOT NULL
);

CREATE TABLE `chantiers` (
    `id` int(12) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nom_de_chantier` int(12) UNSIGNED,
    `heurre` decimal(8,2) NOT NULL,
    `mois_id` int(12) UNSIGNED,
    `prestations_id` int(12) UNSIGNED,
    FOREIGN KEY (`mois_id`) REFERENCES `mois`(`id`),
    FOREIGN KEY (`prestations_id`) REFERENCES `prestations`(`id`),
    FOREIGN KEY (`nom_de_chantier`) REFERENCES `Entreprise`(`id`)
);


INSERT INTO `prestations` (`prestation`) VALUES
('Vitrerire'),
('Remise en état mensuelle');


INSERT INTO `mois` (`mois`) VALUES
    ('Janvier'),
    ('Février'),
    ('Mars'),
    ('Avril'),
    ('Mai'),
    ('Juin'),
    ('Juillet'),
    ('Août'),
    ('Septembre'),
    ('Octobre'),
    ('Novembre'),
    ('Décembre');

INSERT INTO `Entreprise`(`nom_de_chantier`, `code_du_chantier`) VALUES
('AM PRODUCTION', 'AMPO301'),
('ADOMOS', 'ADMO101');