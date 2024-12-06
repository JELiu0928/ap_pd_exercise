	public function {$model}()
	{
		return $this->hasMany('App\Models\PHP\{$ucmodel}', 'second_id', 'id')->doSort();
	}