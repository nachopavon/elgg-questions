<?php
/**
 *	QUESTIONS PLUGIN
 *	@package questions
 *	@author Javier Luces jluces@df-digital.com
 *	@license GNU General Public License (GPL) version 2
 *	@copyright (c) DF-Digital 2009
 *	@link http://www.df-digital.com
 **/
?>
<?php
	require_once(dirname(dirname(dirname(dirname((__FILE__)))))."/utilities/utilities.php");

	global $CONFIG;
	$page = get_input('page');
	$questions_perpage = get_plugin_setting('questions_perpage');
	$limit = $questions_perpage;
	$offset = get_input('offset', 0);
	$order_by = get_input('order_by','time_created');
	$criteria = get_input('criteria','asc');

	gatekeeper();

	$user_id = get_loggedin_userid();

	if($order_by == 'time_created')
	{
		switch($criteria)
		{
			case 'asc':
				$count_questions = get_entities('object','question',$user_id,'time_created asc',$limit,$offset,true);
				$questions = get_entities('object','question',$user_id,'time_created asc',$limit,$offset);
				break;
			case 'desc':
				$count_questions = get_entities('object','question',$user_id,'time_created desc',$limit,$offset,true);
				$questions = get_entities('object','question',$user_id,'time_created desc',$limit,$offset);
				break;
			default:break;
		}
	}
	else
	{
		$count_questions = get_entities('object','question',$user_id,'',1000,0,true);
		$questions = get_entities('object','question',$user_id,'',1000);
		$questions = order_questions_by_criteria($questions,$order_by,$criteria,$limit,$offset);
	}
	if($questions)
	{
		order_question_links($vars['url'],$page);
		echo elgg_view_entity_list($questions, $count_questions, $offset, $limit, true, false, true);
	}
	else
		echo elgg_echo('questions:body:emptyset');
?>