import React, { Component } from 'react';
import {
	BrowserRouter as Router,
	Switch,
	Route,
	Redirect,
} from 'react-router-dom';
import Quill from 'react-quill';

class Metabox extends Component {
	state = {
		postId: 0,
		comments: null,
		newComment: {
			id: null,
			author: null,
			assigned: null,
			comment: null,
		},
	}

	handleComments() {

	}

	render() {
		return (
			<Quill
				defaultValue={ this.state.newComment.content }
				onChange={ ( content, delta, source, editor ) => {
					this.setState( {
						newComment: {
							...this.state.newComment,
							comment: editor.getContents(),
						},
					} );
				} }
			/>
		);
	}
}
export default Metabox;
