import React, { Component } from 'react';
import {
	BrowserRouter as Router,
	Switch,
	Route,
	Redirect
} from 'react-router-dom';
import Quill from 'react-quill';
import wpData from './config';

class Metabox extends Component {
	state = {
		postId: wpData.postID,
		comments: null,
		newComment: {
			id: null,
			author: null,
			assigned: null,
			comment: null
		}
	}

	getComment() {

	}

	handleComment() {

	}

	render() {
		return (
			<form className="comment-form" onSubmit={ this.handleComment }>
				<Quill
					defaultValue={ this.state.newComment.content }
					onChange={ ( content, delta, source, editor ) => {
						let commentID = 0;
						if ( this.state.newComment.id ) {
							commentID = this.state.newComment.id;
						}
						this.setState( {
							newComment: {
								id: commentID + 1,

								comment: editor.getContents()
							}
						} );
					} }
				/>
				<p><button type="submit">Comment</button></p>
			</form>
		);
	}
}
export default Metabox;
