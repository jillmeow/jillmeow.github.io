/*jslint browser: true */
/*global Cookie, $ */

/**
 * Module pattern for Subject functions
 */
var Subjects = (function () {
    "use strict";

    var pub, firstSubjCode, allPapers, selectedPapers;

    // Public interface
    pub = {};

    // List of papers for selection
    allPapers = {};

    // List of papers already selected
    selectedPapers = {};

    // firstSubjCode is used to default to displaying the first subject 
    // if no selection is made
    firstSubjCode = undefined;

    /**
     * Read a list of selected papers from a cookie
     *
     * The selected papers are read from a cookie into selectedPapers.
     * The appropriate checkboxes on the page are then checked.
     */
    function readPaperList() {
        var val, p, thisPaper;
        val = Cookie.get("papers");
        if (val) {
            selectedPapers = JSON.parse(val);
            for (p in selectedPapers) {
                if (selectedPapers.hasOwnProperty(p)) {
                    thisPaper = selectedPapers[p];
                    $("#" + thisPaper.code + thisPaper.semester).prop("checked", true);
                }
            }
        }
    }

    /**
     * Save the list of selected papers in a cookie    
     */
    function writePaperList() {
        Cookie.set("papers", JSON.stringify(selectedPapers));
    }

    /**
     * Update a the list of selected papers and save in a cookie
     *
     * This is called when a checkbox changes.
     */
    function updatePapers() {
        if (this.checked) {
            selectedPapers[this.value] = allPapers[this.value];
        } else {
            delete selectedPapers[this.value];
        }
        writePaperList();
    }

    /**
     * Read a list of papers from an XML file
     *
     * The papers for the currently selected subject are read by an Ajax call
     * This is made synchronously to avoid timing issues.
     * The papers are used to create a list of checkboxes to select papers
     * and also stored in allPapers for use elsewhere.
     */
    function readPapersFromXML() {
        var subjCode;
        subjCode = $("#subjects").find(":selected").val();
        if (!subjCode) {
            subjCode = firstSubjCode;
        }
        $.ajax({type: "GET",
            url: subjCode + ".xml",
            cache: false,
            asynch: false,
            success: function (data) {
                $("#papers").empty();
                allPapers = {};
                $(data).find("paper").each(function () {
                    var code, title, semester, li;
                    code = $($(this).find("code")[0]).text();
                    title = $($(this).find("title")[0]).text();
                    semester = "S" + $($(this).find("semester")[0]).text();
                    li = $("<li>");
                    li.append($("<input>")
                        .attr("type", "checkbox")
                        .attr("class", "paper")
                        .attr("name", "paper")
                        .attr("id", code + semester)
                        .attr("value", code + semester));
                    li.append($("<label>")
                        .attr("for", code)
                        .text(code + ":" + title + " (" + semester + ")"));
                    $("#papers").append(li);
                    allPapers[code + semester] = {};
                    allPapers[code + semester].code = code;
                    allPapers[code + semester].semester = semester;
                    allPapers[code + semester].lectureTimes = [];
                    $(this).find("lecture").each(function () {
                        var lectureTime = {};
                        lectureTime.day = $($(this).find("day")[0]).text();
                        lectureTime.start = $($(this).find("start")[0]).text();
                        lectureTime.end = $($(this).find("end")[0]).text();
                        allPapers[code + semester].lectureTimes.push(lectureTime);
                    });
                });
                $(".paper").change(updatePapers);
                readPaperList();
            }
            });
    }

    /** 
     * Read a list of subjects from an XML file
     *
     * Make an Ajax call to get the list of subjects.
     * This is made synchronously in order to avoid timing issues.
     * The subjects are used to populate a selection box.
     * 
     * Once the subjects are loaded the papers for the current subject are read
     */
    function readSubjectList() {
        $.ajax({type: "GET",
            url: "subjects.xml",
            cache: false,
            asynch: false,
            success: function (data) {
                $(data).find("subject").each(function () {
                    var code, title;
                    code = $($(this).find("code")[0]).text();
                    if (!firstSubjCode) {
                        firstSubjCode = code;
                    }
                    title = $($(this).find("title")[0]).text();
                    $("#subjects").append($("<option>").attr("value", code).text(code + ": " + title));
                });
                readPapersFromXML();
            }
            });
    }

    /** 
     * Setup function for Subjects
     *
     * Reads an initial list of papers from the XML files
     */
    pub.setup = function () {
        readSubjectList();
        $("#subjects").change(readPapersFromXML);
    };

    // Expose public interface
    return pub;

}());

// Call Subjects.setup when the page loads
$(document).ready(Subjects.setup);