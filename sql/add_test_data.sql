BEGIN;
INSERT INTO a_users (login, password, admin, name, email) VALUES ('pinjaliina', 'TOP SECRET', true, 'Pinja-Liina Jalkanen', 'plj@iki.fi');
INSERT INTO a_users (login, password, name, email) VALUES ('anna', 'badpass', 'Anna Äänestäjä', 'anna@posti.invalid');
INSERT INTO a_users (login, password, name, email) VALUES ('kaisa', 'surkusana', 'Kaisa Koiraihminen', 'kaisa@posti.invalid');
INSERT INTO a_polls (name, description, start_time, end_time) VALUES ('Suosikkilemmikki', 'Mikä onkaan se paras lemmikki? Kissa, koira, vai kenties kani? Äänestä suosikkiasi!', '2016-02-06 00:00:00 +02', '2016-02-20 00:00:00 +02');
INSERT INTO a_polls (name, description, start_time, end_time) VALUES ('Vuoden opettaja','Kuka on mantsan laitoksen vuoden opettaja? Äänestä nyt!', '2016-02-07 00:00:00 +02', '2016-02-21 00:00:00 +02');
INSERT INTO a_poll_options (polls_id, name) VALUES (1, 'Kissa');
INSERT INTO a_poll_options (polls_id, name) VALUES (1, 'Koira');
INSERT INTO a_poll_options (polls_id, name) VALUES (1, 'Kani');
INSERT INTO a_poll_options (polls_id, name) VALUES (1, 'Jokin muu');
INSERT INTO a_poll_options (polls_id, name, description) VALUES (2, 'Rami Ratvio', 'Hallitseva mestari');
INSERT INTO a_poll_options (polls_id, name, description) VALUES (2, 'Tuuli Toivonen', 'Haastaja GIS-taitajien joukosta');
INSERT INTO a_poll_options (polls_id, name, description) VALUES (2, 'Juha Karhu', 'Koska laitoksen päällikön luennoilla on aina hauskaa!');
INSERT INTO a_users_polls VALUES (2, 1, false);
INSERT INTO a_users_polls VALUES (2, 2, true);
INSERT INTO a_users_polls VALUES (3, 1, false);
INSERT INTO a_votes (polls_id, poll_options_id) VALUES (2, 5);
COMMIT;