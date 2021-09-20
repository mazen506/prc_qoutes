<html>
	<body>
		<h1>List of Qoutes:</h1>
		<table cellpadding=0 cellspacing=0 border=1>
		<tr>
			<th>رقم العرض</th>
			<th>إسم العرض</th>
			<th>تاريخ العرض</th>
		</tr>
		@foreach ($qoutes as $qoute)
				<tr>
						<td>{{ $qoute->id }}</td>
						<td>{{ $qoute->name }}</td>
						<td>{{ $qoute->date }}</td>
				</tr>
		@endforeach
		</table>
	</body>
</html>