<h2>Help</h2>
<p>
Add this following line in your theme (ex file static.php) where you want to dispay the paging:
</p>
<pre style="font-size:12px; padding-left:40px">
&lt;?php eval($plxShow->callHook('staticPagination')) ?&gt;
</pre>
