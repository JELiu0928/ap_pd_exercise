	public function {$model}()
	{
		return $this->hasMany('App\Models\PHP\{$ucmodel}', 'parent_id', 'id')->doSort();
	}