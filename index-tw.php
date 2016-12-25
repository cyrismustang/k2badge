<html>
	<head>
		<title>艦隊Collection簽名檔產生器</title>
		<meta charset="UTF-8">
		<link href='http://fonts.googleapis.com/css?family=Exo' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="./jquery.min.js"></script>
		<script type="text/javascript" src="./litetabs.jquery.js"></script>
		<script type="text/javascript" src="./jquery.tooltipster.min.js"></script>
		<script>
			var importName = <?php echo isset($_POST["ttkName"]) ? "'" . $_POST["ttkName"] . "'" : "undefined" ?>;
			var importLvl = <?php echo isset($_POST["ttkLvl"]) ? $_POST["ttkLvl"] : "undefined" ?>;
			var importServer = <?php echo isset($_POST["ttkServer"]) ? $_POST["ttkServer"] : "undefined" ?>;
			var importShips = <?php echo isset($_POST["ships"]) ? "'" . $_POST["ships"] . "'" : "undefined" ?>;
			var importK2 = <?php echo isset($_POST["k2Flag"]) ? "'" . $_POST["k2Flag"] . "'" : "undefined" ?>;
			var importColle = <?php echo isset($_POST["colleFlag"]) ? "'" . $_POST["colleFlag"] . "'" : "undefined" ?>;
			var importFleets = <?php echo isset($_POST["fleet"]) ? "'" . $_POST["fleet"] . "'" : "undefined" ?>;
			var apiMode = importName || importLvl || importServer || importShips || importFleets;
		</script>
		<script type="text/javascript" src="./kaini.min.js"></script>
		<script type="text/javascript">
			lang = "tw";
		</script>
		<script type="text/javascript" src="./ga.js"></script>
		<link href="./kaini.css" rel="stylesheet" type="text/css"/>
		<link href="./tooltipster.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<h2>艦隊Collection簽名檔產生器</h2>
		<div id="language"><a href="index.php">EN</a> <a href="index-jp.php">日本語</a> <a href="index-cn.php">简体中文</a> <b>繁體中文</b></div>
		<p>
			本工具需要透過支援Javascript功能的主流瀏覽器（IE10+, Firefox, Chrome, or Safari）才能正常使用。
如本工具有任何更新，請務必清理瀏覽器器快取後再使用。
簽名檔右側的艦娘立繪預設為第一艦隊旗艦（秘書艦）。
如果在使用過程中遇到程式bug或是有任何功能上的建議請於<a target="_blank" href="http://himeuta.org/showthread.php?1818-Tool-Kancolle-Kai-Ni-Badge-Generator">[此處]</a>反應。
		</p>
		<div id="canvasDiv">
			<canvas width="850" height="205" id="result"></canvas>
			<div id="buttonToggles">
				<button type="button" id="displayBadge" class="active">改二</button>
				<button type="button" id="displayPoster">海报</button>
				<button type="button" id="displayRoom">提督室</button>
			</div>
			<div id="buttons">
				<div>
					<span id="loadingDiv">加载图像：</span><span id="loadingProgress"></span>
					<button type="button" id="save">儲存</button>
					<button type="button" id="load">讀取</button>
					<button type="button" id="export">輸出為PNG格式圖片</button>
				</div>
			</div>
		</div>
		<div id="tabs">
			<ul>
				<li><a href="#ttkTab">常規設定</a></li>
				<li><a href="#flagTab">艦隊列表</a></li>
				<li><a href="#shipTab">改二進度＋圖紙艦娘</a></li>
				<li><a href="#colleTab">圖鑑進度海報</a></li>
				<li><a href="#furnTab">家具選擇</a></li>
				<li><a href="#customTab">細部設定</a></li>
			</ul>
			<div id="ttkInfo" name="#ttkTab">
				<div>提督名稱 <input type="text" name="name" maxlength="26" placeholder="無名提督"></div>
				<div>Lv. <input type="number" name="level" min="1" max="120" placeholder="1 - 120"></div>
				<div>所屬伺服器 <select name="server">
					<option value="" disabled selected>------</option>
					<option value="1">横須賀鎮守府</option>
					<option value="2">呉鎮守府</option>
					<option value="3">佐世保鎮守府</option>
					<option value="4">舞鶴鎮守府</option>
					<option value="5">大湊警備府</option>
					<option value="6">トラック泊地</option>
					<option value="7">リンガ泊地</option>
					<option value="8">ラバウル基地</option>
					<option value="9">ショートランド泊地</option>
					<option value="10">ブイン基地</option>
					<option value="11">タウイタウイ泊地</option>
					<option value="12">パラオ泊地</option>
					<option value="13">ブルネイ泊地</option>
					<option value="14">単冠湾泊地</option>
					<option value="15">幌筵泊地</option>
					<option value="16">宿毛泊地</option>
					<option value="17">鹿屋基地</option>
					<option value="18">岩川基地</option>
					<option value="19">佐伯湾泊地</option>
					<option value="20">柱島泊地</option>
				</select></div><br/>
				<div>自訂頭像: <input type='file' id="avatarImg" /> <button type="button" id="avatarClear">移除</button></div><br/>
				<div>顯示家具<input type="checkbox" name="useBG" id="useBG" checked></div> 
				<div>顯示艦隊列表<input type="checkbox" name="k2" id="k2"></div>
				<div>不顯示需改造設計圖之艦娘<input type="checkbox" name="useBlue" id="useBlue" checked></div> 
			</div>
			<div id="flagTab" name="#flagTab">			
				<div id="fleetWrapper">
					<div id="fleetSelect">
						<div id="fleet1" class="chosen">一</div>
						<div id="fleet2">二</div>
						<div id="fleet3">三</div>
						<div id="fleet4">四</div>
					</div>
					<div id="fleets">
						<div id="slot1" class="chosen"></div>
						<div id="slot2"></div>
						<div id="slot3"></div>
						<div id="slot4"></div>
						<div id="slot5"></div>
						<div id="slot6"></div>
						<button id="removeSlot" type="button">Remove</button>
					</div>
					<div id="fleetLevels">
						<div>Lv. <input id="level1" type="number" value="1"/></div>
						<div>Lv. <input id="level2" type="number" value="1"/></div>
						<div>Lv. <input id="level3" type="number" value="1"/></div>
						<div>Lv. <input id="level4" type="number" value="1"/></div>
						<div>Lv. <input id="level5" type="number" value="1"/></div>
						<div>Lv. <input id="level6" type="number" value="1"/></div>
					</div>
				</div>
				<div id="avatars" class="shipList">
					<label>DD 駆逐</label>
					<div class="divDD shipClasses"></div>
					<label>CL/CLT 軽巡/雷巡</label>
					<div class="divCL shipClasses"></div>
					<label>CA/CAV 重巡/航巡</label>
					<div class="divCA shipClasses"></div>
					<label>BB/BBV 戦艦/航戦 </label>
					<div class="divBB shipClasses"></div>
					<label>CVL 軽母</label>
					<div class="divCVL shipClasses"></div>
					<label>CV/CVB 航/装母</label>
					<div class="divCV shipClasses"></div>
					<label>SS/SSV 潜/潜母</label>
					<div class="divSS shipClasses"></div>
					<label>AX その他</label>
					<div class="divAX shipClasses"></div>
					<button type="button" id="loadAbyss">深海艦</button>
					<label class="hidden">ADD 深海駆逐</label>
					<div class="divADD shipClasses"></div>
					<label class="hidden">ACL/ACLT 深海軽巡/深海雷巡</label>
					<div class="divACL shipClasses"></div>
					<label class="hidden">ACA/ACAV 深海重巡/深海航巡</label>
					<div class="divACA shipClasses"></div>
					<label class="hidden">ABB/ABBV 深海戦艦/深海航戦 </label>
					<div class="divABB shipClasses"></div>
					<label class="hidden">ACVL/ACV 深海軽母/深海航</label>
					<div class="divACV shipClasses"></div>
					<label class="hidden">ASS/ASSV 深海潜/深海潜母</label>
					<div class="divASS shipClasses"></div>
					<label class="hidden">AINS 深海陸上</label>
					<div class="divAINS shipClasses"></div>
					<label class="hidden">AAX その他</label>
					<div class="divAAX shipClasses"></div>
				</div>
			</div>
			<div name="#shipTab">
				<div class="shipClass" id="dd">
					<h3>駆逐</h3>
					<div class="shipOptions">
						<div>
							<span><input type="checkbox" name="fubuki2" id="fubuki2"></span>
							<label for="fubuki2">吹雪 (70)</label>
						</div>
						<div>
							<span><input type="checkbox" name="murakumo3" id="murakumo3"></span>
							<label for="murakumo3">叢雲 (70)</label>
						</div>
						<div>
							<span><input type="checkbox" name="ayanami2" id="ayanami2"></span>
							<label for="ayanami2">綾波 (70)</label>
						</div>
						<div>
							<span><input type="checkbox" name="mutsuki3" id="mutsuki3"></span>
							<label for="mutsuki3">睦月 (65)</label>
						</div>
						<div>
							<span><input type="checkbox" name="kisaragi3" id="kisaragi3"></span>
							<label for="kisaragi3">如月 (65)</label>
						</div>
						<div>
							<span><input type="checkbox" name="satsuki2" id="satsuki2"></span>
							<label for="satsuki2">皐月 (75)</label>
						</div>
						<div>
							<span><input type="checkbox" name="ushio2" id="ushio2"></span>
							<label for="ushio2">潮 (60)</label>
						</div>
						<div>
							<span><input type="checkbox" name="akatsuki2" id="akatsuki2"></span>
							<label for="akatsuki2">暁 (70)</label>
						</div>
						<div>
							<span><input type="checkbox" name="verniy1" id="verniy1"></span>
							<label for="verniy1">ヴェールヌイ (70)</label>
						</div>
						<div>
							<span><input type="checkbox" name="hatsuharu2" id="hatsuharu2"></span>
							<label for="hatsuharu2">初春 (65)</label>
						</div>
						<div>
							<span><input type="checkbox" name="hatsushimo2" id="hatsushimo2"></span>
							<label for="hatsushimo2">初霜 (70)</label>
						</div>
						<div>
							<span><input type="checkbox" name="yuudachi2" id="yuudachi2"></span>
							<label for="yuudachi2">夕立 (55)</label>
						</div>
						<div>
							<span><input type="checkbox" name="shigure2" id="shigure2"></span>
							<label for="shigure2">時雨 (60)</label>
						</div>
						<div>
							<span><input type="checkbox" name="kawakaze4" id="kawakaze4"></span>
							<label for="kawakaze4">江風 (75)</label>
						</div>
						<div>
							<span><input type="checkbox" name="asashio2" id="asashio2"></span>
							<label for="asashio2">朝潮 (70/85)</label>
						</div>
						<div class="kai blueprint">
							<span><input type="checkbox" name="ooshio2" id="ooshio2"></span>
							<label for="ooshio2">大潮 (65)</label>
						</div>
						<div>
							<span><input type="checkbox" name="kasumi2" id="kasumi2"></span>
							<label for="kasumi2">霞 (75/88)</label>
						</div>
						<div>
							<span><input type="checkbox" name="z12" id="z12"></span>
							<label for="z12">レーベレヒト・マース (70)</label>
						</div>
						<div>
							<span><input type="checkbox" name="z32" id="z32"></span>
							<label for="z32">マックス・シュルツ (70)</label>
						</div>
					</div>
				</div>
				<div class="shipClass" id="cl">
					<h3>軽巡</h3>
					<div class="shipOptions">
						<div><span><input type="checkbox" name="kitakami3" id="kitakami3"></span><label for="kitakami3">北上 (50)</label></div>
						<div><span><input type="checkbox" name="ooi3" id="ooi3"></span><label for="ooi3">大井 (50)</label></div>
						<div><span><input type="checkbox" name="kiso2" id="kiso2"></span><label for="kiso2">木曾 (65)</label></div>
						<div class="kai blueprint"><span><input type="checkbox" name="kinu2" id="kinu2"></span><label for="kinu2">鬼怒 (75)</label></div>
						<div class="kai blueprint"><span><input type="checkbox" name="abukuma2" id="abukuma2"></span><label for="abukuma2">阿武隈 (75)</label></div>
						<div><span><input type="checkbox" name="isuzu2" id="isuzu2"></span><label for="isuzu2">五十鈴 (50)</label></div>
						<div><span><input type="checkbox" name="sendai2" id="sendai2"></span><label for="sendai2">川内 (60)</label></div>
						<div><span><input type="checkbox" name="jintsuu2" id="jintsuu2"></span><label for="jintsuu2">神通 (60)</label></div>
						<div><span><input type="checkbox" name="naka2" id="naka2"></span><label for="naka2">那珂 (48)</label></div>
					</div>
				</div>
				<div class="shipClass" id="ca">
					<h3>重巡</h3>
					<div class="shipOptions">
						<div><span><input type="checkbox" name="furutaka2" id="furutaka2"></span><label for="furutaka2">古鷹 (65)</label></div>
						<div><span><input type="checkbox" name="kako2" id="kako2"></span><label for="kako2">加古 (65)</label></div>
						<div><span><input type="checkbox" name="kinugasa2" id="kinugasa2"></span><label for="kinugasa2">衣笠 (55)</label></div>
						<div><span><input type="checkbox" name="myoukou2" id="myoukou2"></span><label for="myoukou2">妙高 (70)</label></div>
						<div><span><input type="checkbox" name="nachi2" id="nachi2"></span><label for="nachi2">那智 (65)</label></div>
						<div><span><input type="checkbox" name="haguro2" id="haguro2"></span><label for="haguro2">羽黒 (65)</label></div>
						<div><span><input type="checkbox" name="ashigara2" id="ashigara2"></span><label for="ashigara2">足柄 (65)</label></div>
						<div><span><input type="checkbox" name="maya2" id="maya2"></span><label for="maya2">摩耶 (75)</label></div>
						<div class="kai blueprint"><span><input type="checkbox" name="choukai2" id="choukai2"></span><label for="choukai2">鳥海 (65)</label></div>
						<div class="kai blueprint"><span><input type="checkbox" name="tone2" id="tone2"></span><label for="tone2">利根 (70)</label></div>
						<div class="kai blueprint"><span><input type="checkbox" name="chikuma2" id="chikuma2"></span><label for="chikuma2">筑摩 (70)</label></div>
					</div>
				</div>
				<div class="shipClass" id="bb">
					<h3>戦艦</h3>
					<div class="shipOptions">
						<div><span><input type="checkbox" name="kongou2" id="kongou2"></span><label for="kongou2">金剛 (75)</label></label></div>
						<div><span><input type="checkbox" name="hiei2" id="hiei2"></span><label for="hiei2">比叡 (75)</label></div>
						<div><span><input type="checkbox" name="haruna2" id="haruna2"></span><label for="haruna2">榛名 (80)</label></div>
						<div><span><input type="checkbox" name="kirishima2" id="kirishima2"></span><label for="kirishima2">霧島 (75)</label></div>
						<div class="kai blueprint"><span><input type="checkbox" name="fusou3" id="fusou3"></span><label for="fusou3">扶桑 (80)</label></div>
						<div class="kai blueprint"><span><input type="checkbox" name="yamashiro3" id="yamashiro3"></span><label for="yamashiro3">山城 (80)</label></div>
						<div class="blueprint"><span><input type="checkbox" name="bismarck3" id="bismarck3"></span><label for="bismarck3">zwei (50)</label></div>
						<div class="kai blueprint"><span><input type="checkbox" name="bismarck4" id="bismarck4"></span><label for="bismarck4">drei (75)</label></div>
						<div class="blueprint"><span><input type="checkbox" name="italia1" id="italia1"></span><label for="italia1">イタリア (35)</label></div>
						<div class="blueprint"><span><input type="checkbox" name="roma2" id="roma2"></span><label for="roma2">ローマ (35)</label></div>
					</div>
				</div>
				<div class="shipClass" id="cvl">
					<h3>軽母</h3>
					<div class="shipOptions">
						<div><span><input type="checkbox" name="ryuujou3" id="ryuujou3"></span><label for="ryuujou3">龍驤 (75)</label></div>
						<div><span><input type="checkbox" name="junyou2" id="junyou2"></span><label for="junyou2">隼鷹 (80)</label></div>
						<div><span><input type="checkbox" name="chitosecvl2" id="chitosecvl2"></span><label for="chitosecvl2">千歳航 (50)</label></div>
						<div><span><input type="checkbox" name="chiyodacvl2" id="chiyodacvl2"></span><label for="chiyodacvl2">千代田 (50)</label></div>
						<div class="kai blueprint"><span><input type="checkbox" name="ryuuhou2" id="ryuuhou2"></span><label for="ryuuhou2">龍鳳改 (50)</label></div>
					</div>
				</div>
				<div class="shipClass" id="cv">
					<h3>航</h3>
					<div class="shipOptions">
						<div><span><input type="checkbox" name="souryuu2" id="souryuu2"></span><label for="souryuu2">蒼龍 (78)</label></div>
						<div ><span><input type="checkbox" name="hiryuu2" id="hiryuu2"></span><label for="hiryuu2">飛龍 (77)</label></div>
						<div class="kai blueprint prototype"><span><input type="checkbox" name="shoukaku2" id="shoukaku2"></span><label for="shoukaku2">翔鶴 (80/88)</label></div>
						<div class="kai blueprint prototype"><span><input type="checkbox" name="zuikaku3" id="zuikaku3"></span><label for="zuikaku3">瑞鶴 (77/90)</label></div>
						<div class="blueprint"><span><input type="checkbox" name="unryuu2" id="unryuu2"></span><label for="unryuu2">雲龍 (50)</label></div>
						<div class="blueprint"><span><input type="checkbox" name="amagi2" id="amagi2"></span><label for="amagi2">天城 (50)</label></div>
						<div class="blueprint"><span><input type="checkbox" name="katsuragi2" id="katsuragi2"></span><label for="katsuragi2">葛城 (50)</label></div>
					</div>
				</div>
				<div class="shipClass" id="ss">
					<h3>潜</h3>
					<div class="shipOptions">
						<div><span><input type="checkbox" name="ro5001" id="ro5001"></span><label for="ro5001">呂500 (55)</label></div>
					</div>
				</div>
				<div style="clear:both">
					<input type="checkbox" id="selectAll"><label for="selectAll">全選</label>
				</div>
			</div>
		<div id="colleDiv" name="#colleTab">
			<div class="shipList">
				<label>DD 駆逐</label>
				<div class="divDD shipClasses"></div>
				<label>CL/CLT 軽巡/雷巡</label>
				<div class="divCL shipClasses"></div>
				<label>CA/CAV 重巡/航巡</label>
				<div class="divCA shipClasses"></div>
				<label>BB/BBV 戦艦/航戦 </label>
				<div class="divBB shipClasses"></div>
				<label>CVL 軽母</label>
				<div class="divCVL shipClasses"></div>
				<label>CV/CVB 航/装母</label>
				<div class="divCV shipClasses"></div>
				<label>SS/SSV 潜/潜母</label>
				<div class="divSS shipClasses"></div>
				<label>AX その他</label>
				<div class="divAX shipClasses"></div>
			</div>
		</div>
		<div id="furndiv" name="#furnTab">
			<div class="furnitureClass invert" id="Floor">
				<h3>床</h3>
				<div class="shipOptions">
					<div><input type="radio" name="floor" value="001" id="f1" checked><label for="f1">鎮守府の床</label></div>
					<div><input type="radio" name="floor" value="002" id="f2"><label for="f2">ナチュラルな床</label></div>
					<div><input type="radio" name="floor" value="003" id="f3"><label for="f3">桜舞う春のフローリング</label></div>
					<div><input type="radio" name="floor" value="004" id="f4"><label for="f4">新緑のフローリング</label></div>
					<div><input type="radio" name="floor" value="005" id="f5"><label for="f5">高級フローリング</label></div>
					<div><input type="radio" name="floor" value="006_1" id="f6_1"><label for="f6_1">砂浜の床1</label></div>
					<div><input type="radio" name="floor" value="006_2" id="f6_2"><label for="f6_2">砂浜の床2</label></div>
					<div><input type="radio" name="floor" value="007" id="f7"><label for="f7">ブルーカーペット</label></div>
					<div><input type="radio" name="floor" value="009" id="f9"><label for="f9">白い石版タイル</label></div>
					<div><input type="radio" name="floor" value="012" id="f12"><label for="f12">小花柄カーペット</label></div>
					<div><input type="radio" name="floor" value="014" id="f14"><label for="f14">桜の床</label></div>
					<div><input type="radio" name="floor" value="017" id="f17"><label for="f17">ピンクの床</label></div>
					<div><input type="radio" name="floor" value="020" id="f20"><label for="f20">西欧風カーペット</label></div>
					<div><input type="radio" name="floor" value="021" id="f21"><label for="f21">真っ赤な高級絨毯</label></div>
					<div><input type="radio" name="floor" value="022" id="f22"><label for="f22">真っ白なフワフワ絨毯</label></div>
					<div><input type="radio" name="floor" value="023_1" id="f23_1"><label for="f23_1">雪原の床1</label></div>
					<div><input type="radio" name="floor" value="023_2" id="f23_2"><label for="f23_2">雪原の床2</label></div>
					<div><input type="radio" name="floor" value="023_2" id="f23_3"><label for="f23_3">雪原の床3</label></div>
					<div><input type="radio" name="floor" value="024" id="f24"><label for="f24">春色の床</label></div>
					<div><input type="radio" name="floor" value="025" id="f25"><label for="f25">青畳</label></div>
					<div><input type="radio" name="floor" value="031" id="f31"><label for="f31">飛行甲板</label></div>
					<div><input type="radio" name="floor" value="033" id="f33"><label for="f33">コンクリート床</label></div>
					<div><input type="radio" name="floor" value="034" id="f34"><label for="f34">ラクガキ床</label></div>
					<div><input type="radio" name="floor" value="035" id="f35"><label for="f35">戦艦タイルの床</label></div>
					<div><input type="radio" name="floor" value="037" id="f37"><label for="f37">い草の畳</label></div>
					<div><input type="radio" name="floor" value="038" id="f38"><label for="f38">浜茶屋の床</label></div>
					<div><input type="radio" name="floor" value="039" id="f39"><label for="f39">卯月の床</label></div>
				</div>
			</div>
			<div class="furnitureClass invert" id="Wall">
				<h3>壁紙</h3>
				<div class="shipOptions">
					<div><input type="radio" name="wall" value="001" id="w1" checked><label for="w1">普通の壁紙</label></div>
					<div><input type="radio" name="wall" value="002" id="w2" ><label for="w2">低予算な壁紙</label></div>
					<div><input type="radio" name="wall" value="003" id="w3" ><label for="w3">Simple Japanese Wallpaper<br/>和のシンプル壁紙</div>
					<div><input type="radio" name="wall" value="004" id="w4" ><label for="w4">緑の壁紙</label></label></div>
					<div><input type="radio" name="wall" value="005" id="w5"><label for="w5">春仕様の壁紙</label></div>
					<div><input type="radio" name="wall" value="007" id="w7"><label for="w7">チョコレートの壁紙</label></div>
					<div><input type="radio" name="wall" value="008" id="w8"><label for="w8">ポップな壁紙</label></div>
					<div><input type="radio" name="wall" value="009" id="w9"><label for="w9">お菓子作りの壁紙</label></div>
					<div><input type="radio" name="wall" value="010" id="w10"><label for="w10">高級和風壁紙</label></div>
					<div><input type="radio" name="wall" value="011" id="w11"><label for="w11">家具職人の壁紙</label></div>
					<div><input type="radio" name="wall" value="012" id="w12"><label for="w12">秋仕様の壁紙</label></div>
					<div><input type="radio" name="wall" value="013" id="w13"><label for="w13">シンプルモダン壁紙</label></div>
					<div><input type="radio" name="wall" value="014" id="w14"><label for="w14">軍艦色の壁</label></div>
					<div><input type="radio" name="wall" value="015" id="w15"><label for="w15">白い冬の壁紙</label></div>
					<div><input type="radio" name="wall" value="016" id="w16"><label for="w16">青い壁紙</label></div>
					<div><input type="radio" name="wall" value="017" id="w17"><label for="w17">高級赤煉瓦の壁</label></div>
					<div><input type="radio" name="wall" value="018" id="w18"><label for="w18">チェック＆リーフ壁紙</label></div>
					<div><input type="radio" name="wall" value="019" id="w19"><label for="w19">木板の壁</label></div>
					<div><input type="radio" name="wall" value="020" id="w20"><label for="w20">高級木材の壁</label></div>
					<div><input type="radio" name="wall" value="021" id="w21"><label for="w21">折鶴の壁紙</label></div>
					<div><input type="radio" name="wall" value="022" id="w22"><label for="w22">緑の和壁紙</label></div>
					<div><input type="radio" name="wall" value="023" id="w23"><label for="w23">新緑の壁紙</label></div>
					<div><input type="radio" name="wall" value="024" id="w24"><label for="w24">ピンクドット壁紙</label></div>
					<div><input type="radio" name="wall" value="026" id="w26"><label for="w26">冬のモダンアート壁紙</label></div>
					<div><input type="radio" name="wall" value="027" id="w27"><label for="w27">和モダンアート壁紙</label></div>
					<div><input type="radio" name="wall" value="028" id="w28"><label for="w28">桃の節句の壁紙</label></div>
					<div><input type="radio" name="wall" value="030" id="w30"><label for="w30">新春の壁紙</label></div>
					<div><input type="radio" name="wall" value="031" id="w31"><label for="w31">コンクリート壁</label></div>
					<div><input type="radio" name="wall" value="032" id="w32"><label for="w32">ピンクコンクリ壁</label></div>
					<div><input type="radio" name="wall" value="033" id="w33"><label for="w33">龍の壁紙</label></div>
					<div><input type="radio" name="wall" value="034" id="w34"><label for="w34">紅葉の壁紙</label></div>
					<div><input type="radio" name="wall" value="035" id="w35"><label for="w35">春色の壁紙</label></div>
					<div><input type="radio" name="wall" value="036" id="w36"><label for="w36">バー仕様の壁</label></div>
					<div><input type="radio" name="wall" value="037" id="w37"><label for="w37">梅紫の壁紙</label></div>
					<div><input type="radio" name="wall" value="038" id="w38"><label for="w38">梅雨の壁紙</label></div>
					<div><input type="radio" name="wall" value="039" id="w39"><label for="w39">浜茶屋の仮設壁</label></div>
					<div><input type="radio" name="wall" value="040" id="w40"><label for="w40">卯月の壁紙</label></div>
				</div>
			</div>
			<div class="furnitureClass invert" id="Desk">
				<h3>椅子＋机</h3>
				<div class="shipOptions">
					<div><input type="radio" name="desk" value="000" id="d0" checked><label for="d0">None</label></div>
					<div><input type="radio" name="desk" value="001" id="d1"><label for="d1">ただの段ボール</label></div>
					<div><input type="radio" name="desk" value="002" id="d2"><label for="d2">椅子</label></div>
					<div><input type="radio" name="desk" value="003" id="d3"><label for="d3">執務机</label></div>
					<div><input type="radio" name="desk" value="005" id="d5"><label for="d5">提督の机</label></div>
					<div><input type="radio" name="desk" value="007" id="d7"><label for="d7">大将の机</label></div>
					<div><input type="radio" name="desk" value="009" id="d9"><label for="d9">インテリア椅子</label></div>
					<div><input type="radio" name="desk" value="011" id="d11"><label for="d11">教室セット「教卓」</label></div>
					<div><input type="radio" name="desk" value="012" id="d12"><label for="d12">モダンチェア</label></div>
					<div><input type="radio" name="desk" value="013" id="d13"><label for="d13">駆逐艦娘のツリー</label></div>
					<div><input type="radio" name="desk" value="015" id="d15"><label for="d15">秋刀魚の食卓</label></div>
					<div><input type="radio" name="desk" value="016" id="d16"><label for="d16">大人の節分セット</label></div>
					<div><input type="radio" name="desk" value="017" id="d17"><label for="d17">撮影セット</label></div>
					<div><input type="radio" name="desk" value="018" id="d18"><label for="d18">早く出しすぎた炬燵</label></div>
					<div><input type="radio" name="desk" value="019" id="d19"><label for="d19">羽毛布団と枕</label></div>
					<div><input type="radio" name="desk" value="020" id="d20"><label for="d20">煎餅布団</label></div>
					<div><input type="radio" name="desk" value="021" id="d21"><label for="d21">床の間</label></div>
					<div><input type="radio" name="desk" value="022" id="d22"><label for="d22">艦娘専用デスク</label></div>
					<div><input type="radio" name="desk" value="023" id="d23"><label for="d23">提督の麻雀卓</label></div>
					<div><input type="radio" name="desk" value="024" id="d24"><label for="d24">西瓜割りセット</label></div>
					<div><input type="radio" name="desk" value="025" id="d25"><label for="d25">高級ミシン</label></div>
					<div><input type="radio" name="desk" value="026" id="d26"><label for="d26">金剛の紅茶セット</label></div>
					<div><input type="radio" name="desk" value="029" id="d29"><label for="d29">ご家庭用プール</label></div>
					<div><input type="radio" name="desk" value="030" id="d30"><label for="d30">ガラステーブル</label></div>
					<div><input type="radio" name="desk" value="032" id="d32"><label for="d32">シングルベッド</label></div>
					<div><input type="radio" name="desk" value="033" id="d33"><label for="d33">板チョコ型の机</label></div>
					<div><input type="radio" name="desk" value="034" id="d34"><label for="d34">布団と枕</label></div>
					<div><input type="radio" name="desk" value="035" id="d35"><label for="d35">ウッディな執務机</label></div>
					<div><input type="radio" name="desk" value="036" id="d36"><label for="d36">温泉檜風呂</label></div>
					<div><input type="radio" name="desk" value="037" id="d37"><label for="d37">七面鳥のご馳走</label></div>
					<div><input type="radio" name="desk" value="038" id="d38"><label for="d38">雛人形豪華四段飾り</label></div>
					<div><input type="radio" name="desk" value="040" id="d40"><label for="d40">提督の書斎机</label></div>
					<div><input type="radio" name="desk" value="041" id="d41"><label for="d41">原稿机</label></div>
					<div><input type="radio" name="desk" value="042a" id="d42a"><label for="d42a">ご家庭用プール「夏」</label></div>
					<div><input type="radio" name="desk" value="042b" id="d42b"><label for="d42b">ご家庭用プール「他」</label></div>
					<div><input type="radio" name="desk" value="043" id="d43"><label for="d43">秋刀魚の食卓</label></div>
					<div><input type="radio" name="desk" value="045" id="d45"><label for="d45">白と青のツリー</label></div>
					<div><input type="radio" name="desk" value="046" id="d46"><label for="d46">鎮守府初詣セット</label></div>
					<div><input type="radio" name="desk" value="047" id="d47"><label for="d47">年越し蕎麦</label></div>
					<div><input type="radio" name="desk" value="048" id="d48"><label for="d48">チョコレートキッチン</label></div>
					<div><input type="radio" name="desk" value="049" id="d49"><label for="d49">洋酒＆ワイン棚</label></div>
					<div><input type="radio" name="desk" value="050" id="d50"><label for="d50">温泉岩風呂</label></div>
					<div><input type="radio" name="desk" value="051" id="d51"><label for="d51">紫陽花鉢の提督机</label></div>
					<div><input type="radio" name="desk" value="052" id="d52"><label for="d52">水風呂</label></div>
					<div><input type="radio" name="desk" value="052a" id="d52a"><label for="d52a">水風呂「水」</label></div>
					<div><input type="radio" name="desk" value="052b" id="d52b"><label for="d52b">水風呂「妖」</label></div>
					<div><input type="radio" name="desk" value="053" id="d53"><label for="d53">鎮守府浜茶屋</label></div>
					<div><input type="radio" name="desk" value="054" id="d54"><label for="d54">鎮守府秋祭りの屋台</label></div>
					<div><input type="radio" name="desk" value="055a" id="d55a"><label for="d55a">鎮守府秋祭りの射的「下」</label></div>
					<div><input type="radio" name="desk" value="055b" id="d55b"><label for="d55b">鎮守府秋祭りの射的「上」</label></div>
					<div><input type="radio" name="desk" value="056" id="d56"><label for="d56">鎮守府秋刀魚祭り</label></div>
					<div><input type="radio" name="desk" value="057" id="d57"><label for="d57">七面鳥のディナー</label></div>
					<div><input type="radio" name="desk" value="058" id="d58"><label for="d58">年末年始の提督大奮発</label></div>
					<div><input type="radio" name="desk" value="059" id="d59"><label for="d59">睦月の机</label></div>
					<div><input type="radio" name="desk" value="060" id="d60"><label for="d60">提督のクッキーキッチン</label></div>
					<div><input type="radio" name="desk" value="061a" id="d61a"><label for="d61a">提督の作る食卓「朝ごはん」</label></div>
					<div><input type="radio" name="desk" value="061b" id="d61b"><label for="d61b">提督の作る食卓「カレー」</label></div>
					<div><input type="radio" name="desk" value="061c" id="d61c"><label for="d61c">提督の作る食卓「フーカデン」</label></div>
					<div><input type="radio" name="desk" value="062" id="d62"><label for="d62">卯月の机</label></div>
				</div>
			</div>
			<div class="furnitureClass invert" id="Object">
				<h3>装飾</h3>
				<div class="shipOptions">
					<div><input type="radio" name="object" value="000" id="o0" checked><label for="o0">None</label></div>
					<div><input type="radio" name="object" value="002" id="o2"><label for="o2">壁掛け古時計</label></div>
					<div><input type="radio" name="object" value="003" id="o3"><label for="o3">お詫び掛け軸</label></div>
					<div><input type="radio" name="object" value="004" id="o4"><label for="o4">ステンドグラス</label></div>
					<div><input type="radio" name="object" value="005" id="o5"><label for="o5">鹿のオブジェ</label></div>
					<div><input type="radio" name="object" value="006" id="o6"><label for="o6">「海上護衛」掛け軸</label></div>
					<div><input type="radio" name="object" value="007" id="o7"><label for="o7">花の絵画</label></div>
					<div><input type="radio" name="object" value="008" id="o8"><label for="o8">「20万の感謝」掛け軸</label></div>
					<div><input type="radio" name="object" value="009" id="o9"><label for="o9">「100万の感謝」掛け軸</label></div>
					<div><input type="radio" name="object" value="010" id="o10"><label for="o10">???</label></div>
					<div><input type="radio" name="object" value="011" id="o11"><label for="o11">「夜戦」掛け軸</label></div>
					<div><input type="radio" name="object" value="012" id="o12"><label for="o12">「50万の感謝」掛け軸</label></div>
					<div><input type="radio" name="object" value="013" id="o13"><label for="o13">「謹賀新年」掛け軸</label></div>
					<div><input type="radio" name="object" value="014" id="o14"><label for="o14">「80万の感謝」掛け軸</label></div>
					<div><input type="radio" name="object" value="015" id="o15"><label for="o15">古い世界地図</label></div>
					<div><input type="radio" name="object" value="016" id="o16"><label for="o16">「なのです」掛け軸</label></div>
					<div><input type="radio" name="object" value="017" id="o17"><label for="o17">「第六駆逐隊」掛け軸</label></div>
					<div><input type="radio" name="object" value="019" id="o19"><label for="o19">小さな観葉植物</label></div>
					<div><input type="radio" name="object" value="021" id="o21"><label for="o21">「舞鶴鎮守府」掛け軸</label></div>
					<div><input type="radio" name="object" value="022" id="o22"><label for="o22">アレンジメント</label></div>
					<div><input type="radio" name="object" value="023" id="o23"><label for="o23">壁掛け図上演習セット</label></div>
					<div><input type="radio" name="object" value="024" id="o24"><label for="o24">「150万の感謝」掛け軸</label></div>
					<div><input type="radio" name="object" value="025" id="o25"><label for="o25">「180万の感謝」掛け軸</label></div>
					<div><input type="radio" name="object" value="026" id="o26"><label for="o26">「一周年記念」掛け軸</label></div>
					<div><input type="radio" name="object" value="027" id="o27"><label for="o27">怪獣映画ポスター</label></div>
					<div><input type="radio" name="object" value="028" id="o28"><label for="o28">富士山の壁画</label></div>
					<div><input type="radio" name="object" value="029" id="o29"><label for="o29">戦艦映画ポスター</label></div>
					<div><input type="radio" name="object" value="031" id="o31"><label for="o31">試作艦戦ポスター</label></div>
					<div><input type="radio" name="object" value="032" id="o32"><label for="o32">教室セット「黒板」</label></div>
					<div><input type="radio" name="object" value="033" id="o33"><label for="o33">「200万の感謝」掛け軸</label></div>
					<div><input type="radio" name="object" value="034" id="o34"><label for="o34">「迷彩主義」掛け軸</label></div>
					<div><input type="radio" name="object" value="035" id="o35"><label for="o35">大きな古時計</label></div>
					<div><input type="radio" name="object" value="036" id="o36"><label for="o36">「横須賀鎮守府」掛け軸</label></div>
					<div><input type="radio" name="object" value="037" id="o37"><label for="o37">「ありがとう」掛け軸</label></div>
					<div><input type="radio" name="object" value="038" id="o38"><label for="o38">冬の飾り付け</label></div>
					<div><input type="radio" name="object" value="039" id="o39"><label for="o39">新春掛け軸二〇一五</label></div>
					<div><input type="radio" name="object" value="040" id="o40"><label for="o40">しめ飾り</label></div>
					<div><input type="radio" name="object" value="041" id="o41"><label for="o41">「250万の感謝」掛け軸</label></div>
					<div><input type="radio" name="object" value="042a" id="o42a"><label for="o42a">武蔵の掛け軸「私は此処だ」</label></div>
					<div><input type="radio" name="object" value="042b" id="o42b"><label for="o42b">武蔵の掛け軸「おかえりなさい」</label></div>
					<div><input type="radio" name="object" value="043" id="o43"><label for="o43">富嶽タイル画</label></div>
					<div><input type="radio" name="object" value="044" id="o44"><label for="o44">「二周年記念」掛け軸</label></div>
					<div><input type="radio" name="object" value="045a" id="o45a"><label for="o45a">「300万の感謝」掛け軸「上」</label></div>
					<div><input type="radio" name="object" value="045b" id="o45b"><label for="o45b">「300万の感謝」掛け軸「下」</label></div>
					<div><input type="radio" name="object" value="046" id="o46"><label for="o46">艦隊氷旗</label></div>
					<div><input type="radio" name="object" value="047" id="o47"><label for="o47">「観艦式」掛け軸</label></div>
					<div><input type="radio" name="object" value="048" id="o48"><label for="o48">「ラバウル基地」掛け軸</label></div>
					<div><input type="radio" name="object" value="049" id="o49"><label for="o49">「ブイン基地」掛け軸</label></div>
					<div><input type="radio" name="object" value="050" id="o50"><label for="o50">艦隊大漁旗</label></div>
					<div><input type="radio" name="object" value="051" id="o51"><label for="o51">「トラック泊地」掛け軸</label></div>
					<div><input type="radio" name="object" value="052a" id="o52a"><label for="o52a">夜のお詫び掛け軸(壱)</label></div>
					<div><input type="radio" name="object" value="052b" id="o52b"><label for="o52b">夜のお詫び掛け軸(壱)「探照灯」</label></div>
					<div><input type="radio" name="object" value="053" id="o53"><label for="o53">夜のお詫び掛け軸(弐)</label></div>
					<div><input type="radio" name="object" value="054" id="o54"><label for="o54">艦隊安全お飾り</label></div>
					<div><input type="radio" name="object" value="055" id="o55"><label for="o55">「呉鎮守府」掛け軸</label></div>
					<div><input type="radio" name="object" value="056" id="o56"><label for="o56">「佐世保鎮守府」掛け軸</label></div>
					<div><input type="radio" name="object" value="057" id="o57"><label for="o57">航空母艦ステンドグラス</label></div>
					<div><input type="radio" name="object" value="058" id="o58"><label for="o58">航空戦艦ステンドグラス</label></div>
					<div><input type="radio" name="object" value="059" id="o59"><label for="o59">「春の一番」掛け軸</label></div>
					<div><input type="radio" name="object" value="060" id="o60"><label for="o60">春の乙型姉妹パネル</label></div>
					<div><input type="radio" name="object" value="061a" id="o61a"><label for="o61a">卯月の掛け軸「上」</label></div>
					<div><input type="radio" name="object" value="061b" id="o61b"><label for="o61b">卯月の掛け軸「下」</label></div>
					<div><input type="radio" name="object" value="062" id="o62"><label for="o62">「三周年記念」掛け軸</label></div>
				</div>
			</div>
			<div class="furnitureClass invert" id="Chest">
				<h3>家具</h3>
				<div class="shipOptions">
					<div><input type="radio" name="chest" value="000" id="c0" checked><label for="c0">None</label></div>
					<div><input type="radio" name="chest" value="003" id="c3"><label for="c3">サイドボード</label></div>
					<div><input type="radio" name="chest" value="004" id="c4"><label for="c4">「霧」の桐箪笥</label></div>
					<div><input type="radio" name="chest" value="005" id="c5"><label for="c5">節分「豆まき」セット</label></div>
					<div><input type="radio" name="chest" value="006" id="c6"><label for="c6">暖炉</label></div>
					<div><input type="radio" name="chest" value="007" id="c7"><label for="c7">チョコケーキと紅茶セット</label></div>
					<div><input type="radio" name="chest" value="008" id="c8"><label for="c8">「長門」「陸奥」の雛人形</label></div>
					<div><input type="radio" name="chest" value="009" id="c9"><label for="c9">エレガントボード</label></div>
					<div><input type="radio" name="chest" value="010" id="c10"><label for="c10">鎮守府のツリー</label></div>
					<div><input type="radio" name="chest" value="011" id="c11"><label for="c11">メルヘンシェルフ</label></div>
					<div><input type="radio" name="chest" value="012" id="c12"><label for="c12">やかんストーブ</label></div>
					<div><input type="radio" name="chest" value="013" id="c13"><label for="c13">クラシックシェルフ</label></div>
					<div><input type="radio" name="chest" value="014" id="c14"><label for="c14">重巡模型と桐箪笥</label></div>
					<div><input type="radio" name="chest" value="015" id="c15"><label for="c15">「赤城」模型と桐箪笥</label></div>
					<div><input type="radio" name="chest" value="016" id="c16"><label for="c16">「長門」模型と桐箪笥</label></div>
					<div><input type="radio" name="chest" value="017" id="c17"><label for="c17">折り畳み机</label></div>
					<div><input type="radio" name="chest" value="019" id="c19"><label for="c19">ハンガーラック</label></div>
					<div><input type="radio" name="chest" value="020" id="c20"><label for="c20">ドレッサー</label></div>
					<div><input type="radio" name="chest" value="022" id="c22"><label for="c22">Z旗の暖炉</label></div>
					<div><input type="radio" name="chest" value="023" id="c23"><label for="c23">緑のプランター</label></div>
					<div><input type="radio" name="chest" value="024" id="c24"><label for="c24">模様替えお掃除セット</label></div>
					<div><input type="radio" name="chest" value="025" id="c25"><label for="c25">しょうぶ和箪笥</label></div>
					<div><input type="radio" name="chest" value="026" id="c26"><label for="c26">診療台セット</label></div>
					<div><input type="radio" name="chest" value="027" id="c27"><label for="c27">教室セット「机」</label></div>
					<div><input type="radio" name="chest" value="028" id="c28"><label for="c28">「武蔵」模型と桐箪笥</label></div>
					<div><input type="radio" name="chest" value="029a" id="c29a"><label for="c29a">「加賀」模型と桐箪笥「航空母」</label></div>
					<div><input type="radio" name="chest" value="029b" id="c29b"><label for="c29b">「加賀」模型と桐箪笥「航空母+妖精」</label></div>
					<div><input type="radio" name="chest" value="029c" id="c29c"><label for="c29c">「加賀」模型と桐箪笥「ヘリ空母」</label></div>
					<div><input type="radio" name="chest" value="029d" id="c29d"><label for="c29d">「加賀」模型と桐箪笥「ヘリ空母+妖精」</label></div>
					<div><input type="radio" name="chest" value="030" id="c30"><label for="c30">だるま</label></div>
					<div><input type="radio" name="chest" value="032" id="c32"><label for="c32">夏先取りセット</label></div>
					<div><input type="radio" name="chest" value="033" id="c33"><label for="c33">リゾートセット</label></div>
					<div><input type="radio" name="chest" value="034" id="c34"><label for="c34">書斎本棚</label></div>
					<div><input type="radio" name="chest" value="036" id="c36"><label for="c36">門松</label></div>
					<div><input type="radio" name="chest" value="037" id="c37"><label for="c37">日本酒＆ウィスキー棚</label></div>
					<div><input type="radio" name="chest" value="038a" id="c38a"><label for="c38a">脱衣所「バスタオル」</label></div>
					<div><input type="radio" name="chest" value="038b" id="c38b"><label for="c38b">脱衣所「航」</label></div>
					<div><input type="radio" name="chest" value="038c" id="c38c"><label for="c38c">脱衣所「軽母」</label></div>
					<div><input type="radio" name="chest" value="038d" id="c38d"><label for="c38d">脱衣所「戦」</label></div>
					<div><input type="radio" name="chest" value="038e" id="c38e"><label for="c38e">脱衣所「駆逐」</label></div>
					<div><input type="radio" name="chest" value="038f" id="c38f"><label for="c38f">脱衣所「潜」</label></div>
					<div><input type="radio" name="chest" value="038g" id="c38g"><label for="c38g">脱衣所</label></div>
					<div><input type="radio" name="chest" value="039" id="c39"><label for="c39">レインコート＆傘掛け</label></div>
					<div><input type="radio" name="chest" value="040" id="c40"><label for="c40">業務用かき氷機</label></div>
					<div><input type="radio" name="chest" value="041" id="c41"><label for="c41">北方迷彩な桐箪笥</label></div>
					<div><input type="radio" name="chest" value="042" id="c42"><label for="c42">鎮守府お茶会セット</label></div>
				</div>
			</div>
			<div class="furnitureClass invert" id="Window">
				<h3>窓枠＋カーテン</h3>
				<div class="shipOptions">
					<div><input type="radio" name="window" value="001" id="p1" data-pType="1" checked><label for="p1">赤カーテンの窓</label></div>
					<div><input type="radio" name="window" value="002" id="p2" data-pType="1"><label for="p2">緑カーテンの窓</label></div>
					<div><input type="radio" name="window" value="003" id="p3" data-pType="1"><label for="p3">青カーテンの窓</label></div>
					<div><input type="radio" name="window" value="004" id="p4" data-pType="full"><label for="p4">鎮守府新年飾り</label></div>
					<div><input type="radio" name="window" value="005" id="p5" data-pType="full"><label for="p5">破魔矢の窓</label></div>
					<div><input type="radio" name="window" value="006" id="p6" data-pType="1"><label for="p6">ちょっとゴージャスな窓</label></div>
					<div><input type="radio" name="window" value="007" id="p7" data-pType="full"><label for="p7">晩秋の高級和窓</label></div>
					<div><input type="radio" name="window" value="008" id="p8" data-pType="1"><label for="p8">青い上品な大窓</label></div>
					<div><input type="radio" name="window" value="009" id="p9" data-pType="full"><label for="p9">広く開いた大窓</label></div>
					<div><input type="radio" name="window" value="010" id="p10" data-pType="2"><label for="p10">白いカーテンの小窓</label></div>
					<div><input type="radio" name="window" value="011" id="p11" data-pType="full"><label for="p11">桃の節句の窓</label></div>
					<div><input type="radio" name="window" value="012" id="p12" data-pType="3"><label for="p12">爽やかな窓</label></div>
					<div><input type="radio" name="window" value="013" id="p13" data-pType="full"><label for="p13">てるてる坊主の窓</label></div>
					<div><input type="radio" name="window" value="014" id="p14" data-pType="full"><label for="p14">紫陽花の窓</label></div>
					<div><input type="radio" name="window" value="015" id="p15" data-pType="full"><label for="p15">お花見窓</label></div>
					<div><input type="radio" name="window" value="016" id="p16" data-pType="1"><label for="p16">鉄格子の窓</label></div>
					<div><input type="radio" name="window" value="017" id="p17" data-pType="1"><label for="p17">お月見窓</label></div>
					<div><input type="radio" name="window" value="018" id="p18" data-pType="3"><label for="p18">防空加工窓</label></div>
					<div><input type="radio" name="window" value="019" id="p19" data-pType="1"><label for="p19">障子デラックス</label></div>
					<div><input type="radio" name="window" value="020" id="p20" data-pType="1"><label for="p20">シンプルフレーム1型</label></div>
					<div><input type="radio" name="window" value="021" id="p21" data-pType="1"><label for="p21">シンプルフレーム2型</label></div>
					<div><input type="radio" name="window" value="022" id="p22" data-pType="full"><label for="p22">豪華なお月見窓</label></div>
					<div><input type="radio" name="window" value="023" id="p23" data-pType="1"><label for="p23">シンプルなすだれ窓</label></div>
					<div><input type="radio" name="window" value="024" id="p24" data-pType="3"><label for="p24">すだれ窓</label></div>
					<div><input type="radio" name="window" value="025" id="p25" data-pType="3"><label for="p25">昔ながらのすりガラス</label></div>
					<div><input type="radio" name="window" value="026" id="p26" data-pType="1"><label for="p26">艦娘による冬の窓</label></div>
					<div><input type="radio" name="window" value="027" id="p27" data-pType="full"><label for="p27">冬のステンドグラス</label></div>
					<div><input type="radio" name="window" value="028" id="p28" data-pType="3"><label for="p28">おしゃれな格子窓</label></div>
					<div><input type="radio" name="window" value="029" id="p29" data-pType="3"><label for="p29">障子</label></div>
					<div><input type="radio" name="window" value="030" id="p30" data-pType="full"><label for="p30">春の高級窓</label></div>
					<div><input type="radio" name="window" value="031" id="p31" data-pType="full"><label for="p31">七夕飾りの窓</label></div>
					<div><input type="radio" name="window" value="032" id="p32" data-pType="full"><label for="p32">蚊取り線香の窓</label></div>
					<div><input type="radio" name="window" value="033" id="p33" data-pType="full"><label for="p33">鎮守府風鈴</label></div>
					<div><input type="radio" name="window" value="034a" id="p34a" data-pType="full"><label for="p34a">花火の窓</label></div>
					<div><input type="radio" name="window" value="034b" id="p34b" data-pType="full"><label for="p34b">花火の窓「赤」</label></div>
					<div><input type="radio" name="window" value="034c" id="p34c" data-pType="full"><label for="p34c">花火の窓「白」</label></div>
					<div><input type="radio" name="window" value="034d" id="p34d" data-pType="full"><label for="p34d">花火の窓「黄」</label></div>
					<div><input type="radio" name="window" value="034e" id="p34e" data-pType="full"><label for="p34e">花火の窓「青」</label></div>
					<div><input type="radio" name="window" value="035" id="p35" data-pType="full"><label for="p35">秋の気配な窓</label></div>
					<div><h4>鎮守府カウンターバー</h4><span><input type="radio" name="window" value="036a" id="p36a" data-pType="full"><label for="p36a">「ビール」</label></span>
					<span><input type="radio" name="window" value="036b" id="p36b" data-pType="full"><label for="p36b">「ウィスキー」</label></span>
					<span><input type="radio" name="window" value="036c" id="p36c" data-pType="full"><label for="p36c">「酒」</label></span>
					<span><input type="radio" name="window" value="036d" id="p36d" data-pType="full"><label for="p36d">"「ワイン」</label></span>
					<span><input type="radio" name="window" value="036e" id="p36e" data-pType="full"><label for="p36e">「ジュース」</label></span>
					<span><input type="radio" name="window" value="036f" id="p36f" data-pType="full"><label for="p36f">「糧食」</label></span>
					<span><input type="radio" name="window" value="036g" id="p36g" data-pType="full"><label for="p36g">「ビール+秋刀」</label></span>
					<span><input type="radio" name="window" value="036i" id="p36i" data-pType="full"><label for="p36i">「ウィスキー+秋刀」</label></span>
					<span><input type="radio" name="window" value="036h" id="p36h" data-pType="full"><label for="p36h">「酒+秋刀」</label></span>
					<span><input type="radio" name="window" value="036j" id="p36j" data-pType="full"><label for="p36j">「ワイン+秋刀」</label></span>
					<span><input type="radio" name="window" value="036s" id="p36s" data-pType="full"><label for="p36s">「糧食+秋刀」</label></span>
					<span><input type="radio" name="window" value="036k" id="p36k" data-pType="full"><label for="p36k">「ビール+七面鳥」</label></span>
					<span><input type="radio" name="window" value="036l" id="p36l" data-pType="full"><label for="p36l">「ウィスキー+オードブル」</label></span>
					<span><input type="radio" name="window" value="036m" id="p36m" data-pType="full"><label for="p36m">「酒+スイーツ」</label></span>
					<span><input type="radio" name="window" value="036n" id="p36n" data-pType="full"><label for="p36n">「ワイン+パネットーネ」</label></span>
					<span><input type="radio" name="window" value="036o" id="p36o" data-pType="full"><label for="p36o">「ジュース+ケーキ」</label></span>
					<span><input type="radio" name="window" value="036p" id="p36p" data-pType="full"><label for="p36p">「ワイン+シュトーレン」</label></span>
					<span><input type="radio" name="window" value="036q" id="p36q" data-pType="full"><label for="p36q">「イタリアワイン+パスタ」</label></span>
					<span><input type="radio" name="window" value="036r" id="p36r" data-pType="full"><label for="p36r">「糧食+ターキー」</label></span>
					<span><input type="radio" name="window" value="036z" id="p36z" data-pType="full"><label for="p36z">「ビール+牛丼」</label></span>
					<span><input type="radio" name="window" value="036t" id="p36t" data-pType="full"><label for="p36t">「ウィスキー+牛皿」</label></span>
					<span><input type="radio" name="window" value="036u" id="p36u" data-pType="full"><label for="p36u">「酒+牛丼」</label></span>
					<span><input type="radio" name="window" value="036v" id="p36v" data-pType="full"><label for="p36v">「ワイン+牛皿」</label></span>
					<span><input type="radio" name="window" value="036w" id="p36w" data-pType="full"><label for="p36w">「ジュース+菱餅+ひなあられ」</label></span>
					<span><input type="radio" name="window" value="036x" id="p36x" data-pType="full"><label for="p36x">「イタリアワイン+牛皿」</label></span>
					<span><input type="radio" name="window" value="036y" id="p36y" data-pType="full"><label for="p36y">「糧食+お持ち帰り牛丼」</label></span>
					</div>
					<div><input type="radio" name="window" value="037" id="p37" data-pType="full"><label for="p37">梅雨の緑カーテン窓</label></div>
					<div><input type="radio" name="window" value="038" id="p38" data-pType="full"><label for="p38">鬼灯の花の窓</label></div>
					<div><input type="radio" name="window" value="039" id="p39" data-pType="full"><label for="p39">浜茶屋の窓</label></div>
					<div><input type="radio" name="window" value="040" id="p40" data-pType="full"><label for="p40">睦月の窓</label></div>
					<div><input type="radio" name="window" value="041" id="p41" data-pType="full"><label for="p41">卯月の窓</label></div>
				</div>
			</div>
			<div class="furnitureClass" id="Outside">
				<h3>當日時間</h3>
				<div class="shipOptions">
					<div><input type="radio" name="outside" value="day" id="t1" checked><label for="t1">昼</label></div>
					<div><input type="radio" name="outside" value="rise" id="t2"><label for="t2">朝</label></div>
					<div><input type="radio" name="outside" value="set" id="t3"><label for="t3">午後</label></div>
					<div><input type="radio" name="outside" value="eve" id="t4"><label for="t4">宵の口</label></div>
					<div><input type="radio" name="outside" value="night" id="t5"><label for="t5">夜</label></div>
					<div><label for="tint-color">色味:</label><input id="tint-color" value="#ffffff" type="color"/></div>
				</div>
			</div>
			<div style="clear:both;"></div>
			</div>
			<div id="customInputs" name="#customTab">
				<div>自訂艦娘立繪: <input type='file' id="shipImg" /> <button type="button" id="shipClear">Clear</button></div>
				<div>艦娘立繪橫軸: <input type="number" id="customX" min="-800" max="800" value="0"> 艦娘立繪縱軸: <input type="number" id="customY" min="-500" max="500" value="0"></div>
				<div>艦娘立繪縮放: +<input type="number" id="customZ" min="-50" max="50" value="0">%</div>
				<div>提督室背景縱軸: <input type="number" id="roomY" min="-173" max="134" value="0"></div>
				<div>空白格子透明度: <input type="number" id="hexOpa" min="0" max="1" step="0.01" value="0.33"></div>
				<hr/>
				<div>自訂背景圖片: <input type='file' id="bgImg" /> <button type="button" id="bgClear">移除</button></div>
				<div>背景圖片橫軸: <input type="number" id="bgX" min="-800" max="800" value="0"> 背景圖片縱軸: <input type="number" id="bgY" min="-500" max="500" value="0"></div>
				<div>背景圖片縮放: <input type="number" id="bgZ" min="10" max="500" value="100">%</div>
				<label for="bgStretch">自動縮放圖片以符合大小?</label><input checked type="checkbox" id="bgStretch"/>
				<div style="margin-top: 10px;">
					<button type="button" id="generate">更新</button>
				</div>
			</div>
		</div>
		<span style="font-family:'Exo';visibility:hidden;">.</span><span style="font-family:'Ubuntu';visibility:hidden;">.</span>
		<div id="footer"><p>© 2014-2016 TBES, all rights belong to their respective owners. Translated by angel84326. Last updated: Jul 29 2016</p></div>
		<div style="visibility:hidden; overflow-y: hidden; height:0;" id="icondump">
			<img src="bg.jpg" id="bg"></img>
			<img src="furniture/chest/000.png" id="r0"></img>
			<img src="rarity/rarity1.jpg" id="r1"></img>
			<img src="rarity/rarity2.jpg" id="r2"></img>
			<img src="rarity/rarity3.jpg" id="r3"></img>
			<img src="rarity/rarity4.jpg" id="r4"></img>
			<img src="rarity/rarity5.jpg" id="r5"></img>
			<img src="rarity/rarity6.jpg" id="r6"></img>
			<img src="rarity/rarity7.jpg" id="r7"></img>
			<img src="rarity/rarity8.jpg" id="r8"></img>
			<img src="icons/fleet/fleet1.png" id="fleet1"></img>
			<img src="icons/fleet/fleet2.png" id="fleet2"></img>
			<img src="icons/fleet/fleet3.png" id="fleet3"></img>
			<img src="icons/fleet/fleet4.png" id="fleet4"></img>
			<img src="icons/fleet/fleet1a.png" id="fleet1a"></img>
			<img src="icons/fleet/fleet2.png" id="fleet2a"></img>
			<img src="icons/fleet/fleet3.png" id="fleet3a"></img>
			<img src="icons/fleet/fleet4.png" id="fleet4a"></img>
			<img src="furniture/wall/001.png" id="activeWall"></img>
			<img src="furniture/floor/001.png" id="activeFloor"></img>
			<img src="furniture/chest/000.png" id="activeChest"></img>
			<img src="furniture/desk/000.png" id="activeDesk"></img>
			<img src="furniture/object/000.png" id="activeObject"></img>
			<img src="furniture/window/001.png" id="activeWindow"></img>
			<img src="furniture/outside/day1.png" id="activeOutside"></img>
			<img id="avatar"></img>
			<img id="customShip"></img>
		</div>
	</body>
</html>
