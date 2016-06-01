<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php
echo "<h1>ANALYSIS</h1>";
require_once('TwitterAPIExchange.php');
require('simple_html_dom.php');
include('clear_stop_words_fn.php');
include('titles_function.php');
$user = $_POST['user'];
$number = $_POST['number'];
$settings = array(
'oauth_access_token'=> "3043501246-7orEMGioYBrRlhENUFYMLpK9epQMgicagID4xDC",
'oauth_access_token_secret'=>"26pFe9e7y5790tuIhDeUKmospxabYvTHzJC60Z1p7KqTU",
'consumer_key'=>"kQbcxjPgKj8KEBfRXs0jHa9m1",
'consumer_secret'=>"XayolKKs5fzb1qBbeUafBW3FhWfvUI2TquUhKZIB0PkZC7QKi7");

$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";
$getfield = '?screen_name='.$user.'&count='.$number;
//$getfield = '?screen_name=klausebergeron&count=2';
$twitter = new TwitterAPIExchange($settings);
 $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
$returnstring = json_decode($twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest(),$assoc = TRUE); //Lzak omitted ,$assoc = TRUE)
			 
/*if($string["errors"][0]["message"] != "")
	{echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned
the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
*/
$text_string = array();
$count1 = 1;
$counttweets = 1;
foreach($returnstring as $ind=>$tweet) //for every tweet in the account
{
if($tweet['entities']['urls'])
{
	
	foreach($tweet['entities']['urls'] as $id2=>$url)	//for each 
	{
		echo /*$tweet['text'].*/"<br/>".$url['expanded_url']."<br/>";
		$texturl=$url['expanded_url'];
		$plaintext = file_get_html($texturl)->plaintext; //get plaintext from url using simple_html_dom is string
		//echo "<br/>";$html_text_object = file_get_html($texturl); //use html special chars and/or htmlentities
				$html_text_object = file_get_html($texturl);
				$html_text_string = htmlspecialchars($html_text_object);
				//echo $html_text_string;
				$title = get_titles($html_text_string); //title is array
	}
	if (!$plaintext)
		{	
			echo "NOPE!!";
			continue;
		}
	//$tweet['text'] is a string 
	//plainttext is a string
$preliminary_words = preg_split("/[,\.\s\W]/", $plaintext); //$preliminary_words is the array of plainttext
$ptweettextarray = preg_split("/[,\.:\s\/]+/", $tweet['text'], -1, PREG_SPLIT_DELIM_CAPTURE| PREG_SPLIT_NO_EMPTY); //tweet['text'] as an array broken up by comma space or period
$words = array();
$words = clear_stopwords($preliminary_words); //words is url text w/o stopwords
$word_count = array();
$charmatch = '/^[a-zA-Z]{2,}$/';
$tcharmatch = '/^[@#a-zA-Z]+$/';
foreach ($words as $oneword)
{
	if(preg_match($charmatch, $oneword))
	{
		if(array_key_exists($oneword, $word_count))
			$word_count[$oneword]++;
		else
			$word_count[$oneword]=1;
	}
}
$tweettextarray = clear_stopwords($ptweettextarray);
echo "Tweet text the API pulls: ".$tweet['text']." (it's a string)<br>";
echo "tweet text: "; //when I split the $tweet['text'] string into array it gets rid of all the symbols
print_r($tweettextarray);
echo " end";
$ttextcount = array();
foreach($tweettextarray as $tweetword)
{
	if (preg_match($tcharmatch, $tweetword))
	{
		if(array_key_exists($tweetword, $ttextcount))
			$ttextcount[$tweetword]++;
		else
			$ttextcount[$tweetword]=1;
	}
}
echo "<br><br>ttext count! ";//should be words in tweet without stopwords but with @ symbols
print_r($ttextcount);
//ttextcount is the words in the twitter post counted (not that it's necessary)
//and rid of stopwords
$count = 1;
arsort($word_count);
asort($ttextcount);
$corrolation = array();
$title_corrolation = array();
foreach($ttextcount as $tweetword=>$tind)
{
	foreach($title as $title_index=>$title_word)
			{
				if ($tweetword == $title_word)
				{
					$title_corrolation[$tcind] = $tweetword;
					$tcind++;
				}
			}
}
?>
<text style="font-size:20px; font-family:'Arial'"> <?php echo $counttweets.").";?>Tweet: <?php $cleantext = preg_replace('/â€™/', '\'', $tweet['text']); 
echo $cleantext; 
echo "<br>   Title: ".implode(" ",$title);
		?></text>
<table border="2" style="width=100%">
<tr>
    <th>Word from linked page</th>
	<th>Count</th>
    <th>Tweet</th>
	<th>Title</th>
  </tr><?php
foreach($word_count as $oneword=>$ind)
{
	if ($count <= 50)
	{
		echo "<tr>";
		echo "<td>".$oneword."</td><td>".$word_count[$oneword]."</td><td>"; //$word_count[$oneword] is the number of times word appears
		foreach($ttextcount as $tweetword=>$tind) //twitter words count array as word points to its number of repeats
		{
			if($oneword == $tweetword)
			{
				$corrolation[$cind] = $tweetword;
				$cind++;
				echo $tweetword;
			}
			
		}
		echo "</td><td>";
		foreach($title as $title_index=>$title_word)
		{
			if ($oneword == $title_word)
			{
				echo $title_word;
				break;
			}
		}
		echo "</td></tr>"; 
		$count++; //count is to select the top ten words
	}
}
	echo "<tr><td> This tweet has ";
	if (sizeof($corrolation)==0)
		echo " no";
	else
		echo sizeof($corrolation);
	echo " word(s) in URL&tweet and ";
	if (sizeof($title_corrolation)==0)
		echo "no";
	else
		echo sizeof($title_corrolation);
	echo " word(s) in tweet&title.";
echo "</table>";
$percent = round(((sizeof($corrolation)/sizeof($tweettextarray))*100), 2);

?><text style="font-size:20px; font-family:'Arial'">
<?echo $percent;?>
% of the (non-stopword) words in this tweet show up frequently in it's url.</text><br/><br/><?

$counttweets++;

$totalpercent += $percent;
}
}
?><text style="font-size:20px; font-family:'Arial'"><br/><br/><?php 
echo "Percent for ".$user." (based on ".$number." of tweets, ".--$counttweets." containing links) on average: <b>";
echo $totalpercent / $counttweets;
echo "%";?></text></b>"