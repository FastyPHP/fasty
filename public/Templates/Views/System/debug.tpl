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