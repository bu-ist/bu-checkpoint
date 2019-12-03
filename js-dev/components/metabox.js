import React, { Component } from 'react';
import {
	BrowserRouter as Router,
	Switch,
	Route,
	Redirect
} from 'react-router-dom';
import Quill from 'react-quill';
import vars from './config';

class Metabox extends Component {
	state = {
		postId: vars.postID,
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
								author: vars.user,
								assigned: '',
								comment: editor.getContents()
							}
						} );
					} }
				/>
				<p><button type="submit">Add Comment</button></p>
			</form>
		);
	}
}
export default Metabox;
