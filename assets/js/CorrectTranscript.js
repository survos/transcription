import React from 'react';
import ReactDom from 'react-dom';
import $ from 'jquery';
import { getTranscript } from './transcript_api';

let Amplitude = require('amplitudejs');

import PropTypes from 'prop-types';
import CorrectApp from "./CorrectApp";

export default class CorrectTranscript extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            highlightedRowId: null,
            transcript: {paragraphs: []},
            isLoaded: false,
            getNumberOfCharacters: 1
        };


        this.handleClick = this.handleClick.bind(this);
    }

    componentDidMount() {
        getTranscript()
            .then((data) => {
                this.setState({
                    transcript: data,
                    isLoaded: true
                })
            });
    }

    handleClick(event) {
        // this.setState({student, });
        var
            color = '',
            span = null;

        let correct = $('#correct_transcript').html();
        let student = $('#student_transcript').val();

        if (event.key !== "Enter") {
            return;
        }

    }

    render() {
        const { id, transcript } = this.state;
        console.log(transcript);
        return (
            <div>
                {transcript.paragraphs.map( (para, idx) => (
                    <CorrectApp key={'ca' + idx} paragraph_id={idx} student={''} corrected={para} />
                )
                )}
                    <button className={'btn btn-primary'} onClick={(event) => this.handleClick(event)}>Check</button>
            </div>

        )
    }
}

CorrectTranscript.propTypes = {
    id: PropTypes.number,
    isLoaded: PropTypes.bool.isRequired
};

