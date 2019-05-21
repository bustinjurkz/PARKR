Dustin Jurkaulionis

URL: 
https://jurkaudj.comp4ww3.com/

Design Decisions:
I do not believe I strayed too far from
the norm in terms of design.

There are some optional form inputs which I 
felt if required, would annoy the user.

On the results.php page, both drivers and owners may submit parking spaces,
as well, both owners and drivers may submit reviews -> I am aware of the implications
of drivers populating their own lots with fake positive reviews but I did not have time
to distinguish via different $_SESSION's

I've made 4 case statements when populating the results.php table, each
having a different combination of a name and/or rating specified.
A name not specified has an empty string value "" as well as
a rating not specified has an empty "" value.  This is because newly
created parking spots do not have ratings but should be included in the results.php
page regardless.

I've tried using include "___.php" and '___.inc' code throughout, please see the include files for
the scripts used.

I've put all scripts in one file - JSscripts.js, as it was difficult to use numerous ones
for both form validation AND populating the google maps api.  

results.php markers on map dynamically displays URL "more information" via string concatenation in function InitMapSearch()

AJAX was used for instant viewing of review for the bonus section.
AJAX server side validation was used (submit_review.php for comments)
Essentially, I made sure rating was between 0 and 10, and name, rating, review
fields were not empty, and that user was actually logged in.

searching by rating results in a new query search in which the ratings (per id) are averaged in the reviews table.
A new spot will have a rating % of 0, thus not appear in any search with a required "min rating", unless "any" is selected, thus making the
0% positive ratings come up.  This was a design choice. After all, 0% positive also means there are no positive (or negative) ratings!
I did so by using JOIN and GROUP BY clauses in the rather large SQL queries in results.php

Image displays fine, set max width / height to 60% on parking.php to align with maps in case file too big
Currently, Spot with Pic and Good Spot have images submitted through the submission button using amazon bucket.  Upload
a .jpg with your parking submission (while logged in) and it should work.

By way of what I accomplished with form validation:
-message displays 'please fill in form!' if user does not submit both
username and password on login page
-if search result (after password is hashed) returns COUNT(*) == 1, then proceed, else display
"Your login credentials were incorrect!".  I did this differently than tutorial 8 because the rowCount() method
was very buggy
-will not submit an empty review "no rating provided" AJAX
-only logged in users can submit a review, but due to my AJAX implementation, an error message is displayed instead at the bottom of the SUBMIT REVIEW button which
users must click in order to go to the login page
-submission.php and register.php have server side form validation via user_submit.php and park_submit.php
-to test the above, remove the onsubmit javascript and "required" keywords on the form inputs

Upon Logging-In, redirect to Home page where "welcome __USERNAME___" is displayed.  The islogged boolean is still in this as
$_SESSION is an array.

There is a home.html and home.php.  My site wasn't indexing home.php as the start page in the conf file (even with restarting apache2) so I just kept both in.
Both are used, e.g. home.php will display a welcome message to the user when they log in, while home.html won't.

I used prepared statements wherever I could (i.e. for the database commands), particularly when submtting user, review,and file. For other queries, I made sure
quotes are escaped to prevent the SQL Injection attacks, though I  did read using prepared statements are more industry standard.

Image upload is MANDATORY

USER:
use username: Jacky with password: pineapple for testing, or register yourself.
I used SHA512 hashing alg.

I did not place my connection.php (PDO connection) file outside my root directory - I did research and more people said it's more trouble than it's worth
due to the possible bugs and errors.  the php file is not viewable to others.

#######
The only thing I believe I did not do was redisplay the form with pre-filled correct data upon server-side errors. The form however submits to itself
