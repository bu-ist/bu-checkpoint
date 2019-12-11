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

	handleComment( e ) {
		console.log( this );
		e.preventDefault();
		const checkpointID = 0;
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
					bu_checkpoint_post_id: this.state.postId
				} )
			}
		).then( ( response ) => {
			return response.json();
		} ).catch( ( err ) => {
			console.error( 'Error: ', err );
		} );
	}

	render() {
		return (
			<form className="comment-form" onSubmit={ this.handleComment.bind( this ) }>
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
