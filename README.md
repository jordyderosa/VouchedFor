# VouchedFor
This is my solution for your coding test. I have used PHP as programming languages and MYSQL as database to store and manage input data.
The first think that i’ve done was thinking about how to design the software in a way that could be easy to maintain and to upgrade. 
The first thing that i have is the input but i don’t know how i’ve received it (i mean from a POST, GET, Rest API, SOAP, from Db, ecc. ) so i would like to have a software that can be adaptable to any type of input. So i have designed an interface , called InputInterface, and a gateway , called InputGateway, to manage this part of software and let developers to easly add new features. Developers have to implements the setInputAssocArray method and they will have added immediately a new inputType into my solution.
The second thing that i’ve done was to design db schema , indexes, and keys constrain with cascade on edit and delete action. I have created 3 tables : users, reviews and logs to store user data, input and a helpfull logs table just to track the trend and have some report if needed. 
All the indicators's rules are below ScoreController class so you can just add , edit or delete as your needs so it’ll be very easy to maintan or to add new rules to the software.
I’ve stored all the db's settings into a config file in the root of the software and i’ve used composer and the autoloader to use namespace for my classes according to the PHP psr-4. 
I’ve assumed that software can’t store user rank higher than 100% and lower than 0%.
As concerning preventing SQL injection i’ve used PDO prepared statement.
