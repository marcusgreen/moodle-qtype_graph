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
 * Defines the editing form for the graph question type.
 *
 * @package    qtype
 * @subpackage graph
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * graph question editing form definition.
 *
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_graph_edit_form extends question_edit_form {

    protected function definition_inner($mform) {
        //Add fields specific to this question type
        //remove any that come with the parent class you don't 
        global $PAGE;
        $PAGE->requires->jquery();
        $PAGE->requires->js('/question/type/graph/rgraph/RGraph.common.core.js');
        $PAGE->requires->js('/question/type/graph/rgraph/RGraph.common.dynamic.js');
        $PAGE->requires->js('/question/type/graph/rgraph/RGraph.line.js');
        $PAGE->requires->js('/question/type/graph/rgraph/RGraph.bar.js');
        $PAGE->requires->js('/question/type/graph/graphcode.js');

        $graphtypes= ["Line"=>"Line","Bar"=>"Bar","Pie"=>"Pie"];
        $mform->addElement('select', 'graphtypes', get_string('graphtypes', 'qtype_graph'), $graphtypes);
        
        $graphcode =qtype_graph::get_graphcode('bar',array());
        $mform->addElement('textarea', 'graphcode','Graph Code', 'wrap="virtual" rows="20" cols="80"')->setValue($graphcode);
        $mform->addElement('button', 'refreshgraph', 'Refresh Graph');

        $mform->addElement('html',qtype_graph::get_graphstart());
        $mform->addElement('html',$graphcode);
        $mform->addElement('html'," graph.draw(); })(jQuery);</script></div></div>");
        
       // To add combined feedback (correct, partial and incorrect).
       // $this->add_combined_feedback_fields(true);
       // Adds hinting features.
       // $this->add_interactive_settings(true, true);
    }

    protected function data_preprocessing($question) {
        $question = parent::data_preprocessing($question);
        $question = $this->data_preprocessing_hints($question);

        return $question;
    }

    public function qtype() {
        return 'graph';
    }
}
