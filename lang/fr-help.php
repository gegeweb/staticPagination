<h2>Aide</h2>
<p>
Ajouter la ligne suivante dans votre thème (ex fichier static.php) à l'endroit où vous voulez afficher la pagination&nbsp;:
</p>
<pre style="font-size:12px; padding-left:40px">
&lt;?php eval($plxShow->callHook('staticPagination')) ?&gt;
</pre>
