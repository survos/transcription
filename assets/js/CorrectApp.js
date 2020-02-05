import React from 'react';
import ReactDom from 'react-dom';
import $ from 'jquery';
import { getTranscript } from './transcript_api';

let Amplitude = require('amplitudejs');

// import Diff from 'diff';
let Diff = require('diff');
import PropTypes from 'prop-types';

export default class CorrectApp extends React.Component {

    constructor(props) {
        super(props);
        const {student, corrected, paragraphNumber} = props;
        this.state = {
            student: student,
            corrected: corrected
        };

        $('#student_transcript').val(this.state.student);
        // $('#starting_transcript').hide();

        this.handleClick = this.handleClick.bind(this);
    }

    handleClick(event) {
        // this.setState({student, });
        var
            color = '',
            span = null;

        let correct = $('#correct_transcript').html();
        let student  = $('#student_transcript').val();
        console.error(student);
        console.warn(correct);

        if (event.key !== "Enter") {
            // return;
        }

        var diff = Diff.diffChars(student, correct),
            display = document.getElementById('display'),
            fragment = document.createDocumentFragment();

        display.innerHTML = '';

        diff.forEach(function(part){
            // green for additions, red for deletions
            // grey for common parts
            color = part.added ? 'green' :
                part.removed ? 'red' : 'grey';
            span = document.createElement('span');
            span.style.color = color;
            span.appendChild(document
                .createTextNode(part.value));
            fragment.appendChild(span);
        });

        display.appendChild(fragment);

    }

    // removed onKeyDown={(event) => this.handleClick(event)}
    render() {
        const { corrected, student } = this.state;

        // @todo: this needs to be an ajax call to get the diff, then display it.
        return (
            <div>
                <form method={'GET'}>

                {this.props.paragraphNumber}
                <textarea style={{width: '100%', height: '50px'}} id="student_transcript"
                          defaultValue={student} />
                <button className={'btn btn-primary'} onClick={(event) => this.handleClick(event)}>Check Paragraph</button>
                <button className={'btn btn-success'}>Save and Continue</button>
                </form>
            </div>

            )
    }
}

CorrectApp.propTypes = {
    paragraphNumber: PropTypes.number,
    student: PropTypes.string,
    corrected: PropTypes.string
};

