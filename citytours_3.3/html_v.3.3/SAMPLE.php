 <!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<div>
		<p>hoge	</p>
	</div>

	<div>
		<input type="submit" value="編集" onclick="obj=document.getElementById('open').style; obj.display=(obj.display=='none')?'block':'none';">
	</div>

	<!-- 1回目展開 -->
	<div id="open" style="display:none;clear:both;" >
	<p>現在のパスワードを入力してください	</p>
	<input type="password" name="">
	<div>
		<input type="submit" value="確認する" onclick="obj=document.getElementById('open2').style; obj.display=(obj.display=='none')?'block':'none';">
	</div>
	<!-- 1回目展開 End -->

	<!-- ★★確認ボタンが押されて、エエラーがなければ2回目展開 -->

	<!-- 2回目展開 -->
	<!-- ★★ボタン押してもreloadしないでエラー確認 -->

	<div id="open2" style="display:none;clear:both;">

	<!-- copy -->
	<div class="col-md-12 col-sm-12">
		<table>
			<thead>
				<tbody>
					<tr>
						<th>団体名</th>
						<td>
							<input type="text" name="">
						</td>
					</tr>	
				</tbody>				
			</thead>			
		</table>
	</div>
	<div>
		<input type="submit" value="送信">
	</div>

	</div>
	<!-- 2回目展開　End -->


	<script></script>
<form name="pullForm">

    <select name="pullMenu">
        <option value="a.html">aへ遷移</option>
        <option value="b.html">bへ遷移</option>
        <option value="c.html">cへ遷移</option>
    </select>

    <input type="button" value="クリック" onclick="screenChange()"> 
</form>

</body>
</html>

