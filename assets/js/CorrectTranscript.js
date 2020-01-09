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
            paragraphNumber: 1,
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
        const { id, transcript, paragraphNumber } = this.state;
        console.log(transcript);
        return (
            <div>
                {transcript.paragraphs.map( (para, idx) => (
                        <a key={'ca' + idx} href={'/transcript/'}>{idx} </a>
                    )
                )}
                <hr />

                <CorrectApp key={'ca' + paragraphNumber} paragraphNumber={paragraphNumber} student={''} corrected={transcript.paragraphs[paragraphNumber-1]} />
            </div>

        )
    }
}

CorrectTranscript.propTypes = {
    id: PropTypes.number.isRequired,
    paragraphNumber: PropTypes.number.isRequired,
    isLoaded: PropTypes.bool.isRequired
};

