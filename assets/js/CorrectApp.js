import React from 'react';
import ReactDom from 'react-dom';
import $ from 'jquery';

Amplitude = require('amplitudejs');

// import Diff from 'diff';
let Diff = require('diff');
import PropTypes from 'prop-types';

export default class CorrectApp extends React.Component {

    constructor(props) {
        super(props);
        const {student, corrected} = props;
        this.state = {
            student: student,
            corrected: corrected
        };

        $('#student_transcript').val(this.state.student);
        $('#starting_transcript').hide();


        this.handleClick = this.handleClick.bind(this);
    }

    handleClick(event) {
        // this.setState({student, });
        var one = 'beep boop',
            other = 'beep boob blah',
            color = '',
            span = null;

        let correct = $('#correct_transcript').html();
        let student  = $('#student_transcript').val();

        if (event.key !== "Enter") {
            return;
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

    render() {
        const { corrected, student } = this.state;
        return (
            <div>
                <textarea style={{width: '100%', height: '150px'}} id="student_transcript" onKeyDown={(event) => this.handleClick(event)} defaultValue={student} />
                <button className={'btn btn-primary'} onClick={(event) => this.handleClick(event)}>Check</button>
            </div>

            )
    }
}

CorrectApp.propTypes = {
    student: PropTypes.string,
    corrected: PropTypes.string
};

