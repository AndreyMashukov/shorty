{strip}
{include file="header.tpl"}
    <div class="main">
	<p>home page</p>
	<form action="" method="post">
	    <div>
		{form id="longurl"}
		<input type="hidden" name="transition" value="geturl" />
		<input type="submit" value="{"Get short link"|gettext}" class="submit" />
	    </div>
	</form>
	<p>Your short URL is: <span id="result">{if isset($shortURL)}<a href="{$shortURL}">{$shortURL}</a>{/if}</span></p>
    </div>
{include file="footer.tpl"}
{/strip}
