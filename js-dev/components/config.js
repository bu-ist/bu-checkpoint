// Common variables and scripts
'use strict';

const vars = {
	restURL: window.checkpointData.restURL,
	postID: window.checkpointData.postID,
	user: window.checkpointData.author,
};

vars.checkpointURL = vars.restURL + '/bu-checkpoint/';

export default vars;

export function getCheckpoint() {
	const postID = vars.postID;
}
