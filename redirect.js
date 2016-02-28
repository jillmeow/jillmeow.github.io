/**
 * Redirection for index.html
 *
 * If there are any papers chosen, go to the timetable
 * Otherwise go to paper selection
 */

/*jslint browser:true */
/*global Cookie */

/**
 * Redirect the user to an appropriate page
 *
 * If there are no papers chosen, then go to the subject selection page.
 * Otherwise go to the timetable for the current semester (determined by month).
 *
 * Note that we use an anonymous function to avoid adding anything to the 
 * global namespace. This is similar to the Module pattern in some ways.
 *
 */
(function () {
    "use strict";
    var month;
    if (Cookie.get("papers")) {
        month = new Date().getMonth();
        if (month === 11 || month < 2) {
            // December, January, or February
            window.location.replace("summer.html");
        } else if (month < 6) {
            // March to June
            window.location.replace("semester1.html");
        } else {
            // July to November
            window.location.replace("semester2.html");
        }
    } else {
        window.location.replace("subjects.html");
    }
}());