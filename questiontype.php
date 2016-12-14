<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Question type class for the graph question type.
 *
 * @package    qtype
 * @subpackage graph
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/* https://docs.moodle.org/dev/Question_types#Question_type_and_question_definition_classes */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/questionlib.php');
require_once($CFG->dirroot . '/question/engine/lib.php');
require_once($CFG->dirroot . '/question/type/graph/question.php');

/**
 * The graph question type.
 *
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_graph extends question_type {

    /* ties additional table fields to the database */

    public function extra_question_fields() {
        return array('question_graph', 'somefieldname', 'anotherfieldname');
    }

    public function move_files($questionid, $oldcontextid, $newcontextid) {
        parent::move_files($questionid, $oldcontextid, $newcontextid);
        $this->move_files_in_hints($questionid, $oldcontextid, $newcontextid);
    }

    protected function delete_files($questionid, $contextid) {
        parent::delete_files($questionid, $contextid);
        $this->delete_files_in_hints($questionid, $contextid);
    }

    public function save_question_options($question) {
        //TODO
        /* code to save answers to the question_answers table */
        $this->save_hints($question);
    }

    /* populates fields such as combined feedback */

    public function get_question_options($question) {
        global $DB;
        $question->options = $DB->get_record('question_graph', array('questionid' => $question->id), '*', MUST_EXIST);
        parent::get_question_options($question);
    }

    public static function get_graphstart(){
        return "
        <canvas id='cvs' width='600' height='250'>[No canvas support]</canvas><br />
        <div id='container'>
        <div id='graphdisplay'>
        <script>
        $(document).ready(function(){
            RGraph.Clear(document.getElementById('cvs'));
            RGraph.Reset(document.getElementById('cvs'));;
            RGraph.Redraw();";
    }
    public static function get_graphcode($graphtype, array $graphparams) {
        return "var obj= new RGraph.Line({
            id:'cvs',            
            data: [          
                [1,1,10]
            ],
            options: {
                labels: ['Jan','Feb','Mar'],
                adjustable:true
                }
        });";
    }

    protected function initialise_question_instance(question_definition $question, $questiondata) {
        parent::initialise_question_instance($question, $questiondata);
        $this->initialise_question_answers($question, $questiondata);
        parent::initialise_combined_feedback($question, $questiondata);
    }

    public function initialise_question_answers(question_definition $question, $questiondata, $forceplaintextanswers = true) {
        //TODO
    }

    public function import_from_xml($data, $question, qformat_xml $format, $extra = null) {
        if (!isset($data['@']['type']) || $data['@']['type'] != 'question_graph') {
            return false;
        }
        $question = parent::import_from_xml($data, $question, $format, null);
        $format->import_combined_feedback($question, $data, true);
        $format->import_hints($question, $data, true, false, $format->get_format($question->questiontextformat));
        return $question;
    }

    public function export_to_xml($question, qformat_xml $format, $extra = null) {
        global $CFG;
        $pluginmanager = core_plugin_manager::instance();
        $gapfillinfo = $pluginmanager->get_plugin_info('question_graph');
        $output = parent::export_to_xml($question, $format);
        //TODO
        $output .= $format->write_combined_feedback($question->options, $question->id, $question->contextid);
        return $output;
    }

    public function get_random_guess_score($questiondata) {
        // TODO.
        return 0;
    }

    public function get_possible_responses($questiondata) {
        // TODO.
        return array();
    }

}
