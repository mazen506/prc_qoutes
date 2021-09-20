<div class="container">
        <div class="row">
            <div class="col-12 pt-2">
                <a href="/blog" class="btn btn-outline-primary btn-sm">Go back</a>
				<div>
					<label>رقم العرض</label>
					<label>{{ $qoute->id }}</label>
				</div>
				
				<div>
					<label>إسم العرض</label>
					<label> {{ $qoute->name }} </label>
				</div>
				
				<div>
					<label>إسم العرض</label>
					<label> {{ $qoute->note }} </label>
				</div>
				
				<hr>
                <a href="/qoute/{{ $qoute->id }}/edit" class="btn btn-outline-primary">Edit Qoute</a>
                <br><br>
                <form id="delete-frm" class="" action="" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">Delete Qoute</button>
                </form>
				
           </div>				
        </div>
    </div>