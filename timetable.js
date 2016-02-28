

/*jslint browser: true */
/*globals Cookie, $*/

/**
 * Module pattern for Timetable functions
 */
var Timetable = (function () {
    "use strict";

    // Public interface
    var pub;
    pub = {};

    /**
     * Read a list of papers from the cookie
     *
     * This returns a list of papers. Rather than using an array, the papers are stored
     * in an object which then is treated as an associative array (map/dictionary).
     * Papers are represented as objects with a code, semester, and list of lecture times.
     * They are indexed by code+semester.
     *
     * @return A list of papers
     */
    function readPaperList() {
        var val;
        val = Cookie.get("papers");
        if (val) {
            return JSON.parse(val);
        }
        return {};
    }

    /**
     * Show the lectures for a particular paper
     *
     * Lecture times are displayed in a table with a column per day
     * and a row per hour. Clashes are highlighted in red.
     *
     * @param paper The paper to show
     */
    function showLectures(paper) {
        var i, lecture, days, day, start, end, col, row, table, theRow, cell;
        // List of days, used to compute column indices
        days = ["Mon", "Tue", "Wed", "Thu", "Fri"];
        for (i = 0; i < paper.lectureTimes.length; i += 1) {
            lecture = paper.lectureTimes[i];
            day = lecture.day;
            start = parseInt(lecture.start, 10);
            end = parseInt(lecture.end, 10);

            start = start - 8;
            end = end - 8;
            col = days.indexOf(day);
            for (row = start; row < end; row += 1) {
                table = $("table")[0];
                theRow = table.rows[row];
                cell = $($(theRow).find("td")[col]);
                if (cell.text()) {
                    // A clash
                    cell.css("background-color", "#FFAAAA");
                    cell.text(cell.text() + " " + paper.code);
                } else {
                    cell.css("background-color", "#DDDDDD");
                    cell.text(paper.code);
                }
            }
        }
    }

    /**
     * Setup function for Timetable
     *
     * This reads the papers from a cookie and filters them for the appropriate semester.
     * Each remaining paper's lectures are then displayed
     */
    pub.setup = function () {
        var allPapers, pagename, checker, paper;

        allPapers = readPaperList();

        pagename = document.location.href.split('/').pop();

        if (pagename === "semester1.html") {
            checker = function (semester) {
                return semester === "S1" || semester === "SF";
            };
        } else if (pagename === "semester2.html") {
            checker = function (semester) {
                return semester === "S2" || semester === "SF";
            };
        } else if (pagename === "summer.html") {
            checker = function (semester) {
                return semester === "SS";
            };
        } else {
            checker = function () {
                return false;
            };
        }

        for (paper in allPapers) {
            if (allPapers.hasOwnProperty(paper)) {
                if (checker(allPapers[paper].semester)) {
                    showLectures(allPapers[paper]);
                }
            }
        }
    };

    // Expose the public interface
    return pub;

}());

// Call Timetable.setup when the page loads
$(document).ready(Timetable.setup);