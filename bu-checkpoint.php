<?php
/**
 * Plugin Name:     BU Checkpoint
 * Plugin URI:      https://github.com/bu-ist/bu-checkpoint
 * Description:     Editorial workflow for posts and pages.
 * Author:          Boston University, Jim Reevior
 * Text Domain:     bu-checkpoint
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         bu-checkpoint
 */

namespace BU\Plugins\Checkpoint;

define( BU_CHECKPOINT_CPT, 'bu-checkpoint' );
define( BU_CHECKPOINT_STATUS, 'bu-checkpoint-status' );
define( BU_CHECKPINT_STAGES, 'bu-checkpoint-stages' );

require 'inc/taxonomy.php';
require 'inc/post-type.php';
