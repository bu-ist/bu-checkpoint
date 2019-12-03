/* eslint-disable comma-dangle */
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
		console.log( 'STATE', this.state );
		const checkpointID = 0;
		const checkpointMeta = {
			'bu-checkpoint-post-id': this.state.postId,
			'bu-checkpoint-comments': this.state.newComment,
		};
		fetch(
			vars.checkpointURL,
			{
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					accept: 'application/json',
					'X-WP-Nonce': vars.nonce
				},
				body: JSON.stringify( {
					title: vars.title,
					status: 'publish',
					meta: checkpointMeta,
				} )
			}
		).then( ( response ) => {
			return response.json();
		} ).catch( ( err ) => {
			console.error( 'shit', err );
		} );
	}

	render() {
		return (
			<form className="comment-form" onSubmit={ this.handleComment }>
				<Quill
					defaultValue={ this.state.newComment.content }
					onChange={ ( content, delta, source, editor ) => {
						let commentID = 0;
						if ( this.state.newComment.id ) {
							commentID = this.state.newComment.id + 1;
						}
						this.setState( {
							newComment: {
								id: commentID,
								author: vars.user,
								assigned: '',
								comment: editor.getContents(),
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
