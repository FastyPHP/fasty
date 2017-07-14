<script src="Javascript/debug.js?v=1"></script>
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link rel="stylesheet" href="Debug/debug.css">

<div class="debugbar" id="debugbar">
	<div id="debugheader">
		<div class="column">
			<i class="fa fa-clock-o"></i> {$execution} ms
		</div>

		<div class="column">
			<i class="fa fa-rocket"></i> {$peak_ram}
		</div>

		<div class="column" data-opens="tab_request">
			Type {$request.REQUEST_METHOD}
		</div>

		<div class="column" data-opens="tab_queries">
			<i class="fa fa-database"></i> Queries {count($queries)}
		</div>

		<div class="column" data-opens="tab_templates">
			<i class="fa fa-eye"></i> Templates {count($templates)}
		</div>

		<div class="column" data-opens="tab_languages">
			<i class="fa fa-language"></i> Languages {count($languages)}
		</div>

		<div class="toggleButton" id="toggleButton">
			<i class="fa fa-toggle-off" id="toggleIcon"></i>
		</div>
	</div>

	<div class="debugContent">

		<div id="tab_languages" class="debug_tab" style="display: none;">
			{foreach $languages AS $language}
				<div class="debug_row">
					<i class="fa fa-eye"></i> {$language}
				</div>
			{/foreach}
		</div>

		<div id="tab_templates" class="debug_tab" style="display: none;">
			{foreach $templates AS $key => $template}
				<div class="debug_row debug_template" data-id="{$key}">
					<i class="fa fa-language"></i> {$template.template}
				</div>
				{if !empty($template.params)}
					<div class="params" id="paramsForTemplate_{$key}" style="display: none;">
						<table cellspacing="0">
							<tr>
								<th>Param</th>
								<th>Value</th>
							</tr>
							{foreach $template.params AS $key => $val}
								<tr>
									<td>{$key}</td>
									<td>
										{if is_array($val)}
											{' | '|implode:$val}
										{else}
											{$val}
										{/if}
									</td>
								</tr>
							{/foreach}
						</table>
					</div>
				{/if}
			{/foreach}
		</div>

		<div id="tab_queries" class="debug_tab" style="display: none;">
			{foreach $queries AS $key => $query}
				<div class="debug_row debug_query" data-id="{$key}">
					<i class="fa fa-chevron-right"></i> {$query.query}
				</div>
				{if !empty($query.params)}
					<div class="params" id="paramsForQuery_{$key}" style="display: none;">
						<table cellspacing="0">
							<tr>
								<th>Param</th>
								<th>Value</th>
							</tr>
							{foreach $query.params AS $key => $val}
								<tr>
									<td>{$key}</td>
									<td>
										{if is_array($val)}
											{' | '|implode:$val}
										{else}
											{$val}
										{/if}
									</td>
								</tr>
							{/foreach}
						</table>
					</div>
				{/if}
			{/foreach}
		</div>

		<div id="tab_request" class="debug_tab">
			<table cellspacing="0">
				<tr>
					<th>Name</th>
					<th>Value</th>
				</tr>
				{foreach $request AS $key => $val}
					<tr>
						<td>{$key}</td>
						<td>{$val}</td>
					</tr>
				{/foreach}
			</table>
		</div>
	</div>
</div>

<!--<div class="debug_bar" id="debug_panel">
	<div class="collapsed_icon">
		<i class="fa fa-area-chart" aria-hidden="true"></i>
	</div>

	<div class="row debug_header" id="debug_header">
		<div class="container">
			<div class="left-text">Debug panel</div>

			<div class="right-text">
				<div class="col s3">Izvrsavanje<br/>{$execution}ms</div>
				<div class="col s3">Upiti<br/>{count($queries)}</div>
				<div class="col s3">Templatovi<br/>{count($templates)}</div>
				<div class="col s3">Jezici<br/>{count($languages)}</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="container">
			<div class="col s2">
				<ul class="debug_items">
					<li class="debug_item active" data-open="performance"><i class="fa fa-tachometer" aria-hidden="true"></i> Performanse</li>
					<li class="debug_item" data-open="queries"><i class="fa fa-database" aria-hidden="true"></i> Bazni upiti</li>
					<li class="debug_item" data-open="templates"><i class="fa fa-file-text-o" aria-hidden="true"></i> Templatovi</li>
					<li class="debug_item" data-open="languages"><i class="fa fa-language" aria-hidden="true"></i> Jezici</li>
				</ul>
			</div>
			<div class="col s10">
				<div id="debug_page_performance" class="debug_page">
					<div class="row">
						<div class="col s2">
							Vrijeme ucitavanja
						</div>
						<div class="col s10">
							<div class="progressbar">
								<div class="determinate" id="debug_execution_time" data-time="{$execution}"></div>
								<div class="textHolder" id="debug_execution_text">{$execution}ms</div>
							</div>
						</div>
					</div>

					<div class="row debug_stats">
						<div class="col s3">
							Iskoristenost RAM-a<br/>
							{$ram_usage}
						</div>

						<div class="col s3">
							Vrhunac RAM-a<br/>
							{$peak_ram}
						</div>

						<div class="col s3">
							Tip zahtijeva<br/>
							{$request_type}
						</div>
					</div>
				</div>
				<div id="debug_page_queries" class="debug_page" style="display: none;">
					<div class="row">
						<div class="col s12">
							<ul class="debug_items_list">
								{foreach $queries AS $i => $query}
									<li class="query_item" data-id="{$i}">
										{$query.query}
										<div class="query_params params" id="query_params_{$i}" style="display: none;">
											{foreach $query.params AS $key => $val}
												<div class="row">
													<div class="col s2">
														{$key}
													</div>
													<div class="col s10">
														{if $val|is_array}Array
														{else}{$val}
														{/if}
													</div>
												</div>
											{/foreach}
										</div>
									</li>
								{/foreach}
							</ul>
						</div>
					</div>
				</div>
				<div id="debug_page_templates" class="debug_page" style="display: none;">
					<div class="row">
						<div class="col s12">
							<ul class="debug_items_list">
								{foreach $templates AS $i => $template}
									<li class="template_item" data-id="{$i}">
										{$template.template}
										<div class="template_params params" id="template_params_{$i}" style="display: none;">
											{foreach $template.params AS $key => $val}
												<div class="row">
													<div class="col s2">
														{$key}
													</div>
													<div class="col s10">
														{if $val|is_array}Array
														{else}{$val}
														{/if}
													</div>
												</div>
											{/foreach}
										</div>
									</li>
								{/foreach}
							</ul>
						</div>
					</div>
				</div>
				<div id="debug_page_languages" class="debug_page" style="display: none;">
					<div class="row">
						<div class="col s12">
							<ul class="debug_items_list">
								{foreach $languages AS $language}
									<li>
										{$language}
									</li>
								{/foreach}
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>-->
