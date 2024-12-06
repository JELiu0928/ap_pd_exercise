public function getExport(): ExportResponse
    {
        $sql = $this->basicSql(Datalist::class);
        $data = (clone $sql)->get();
        $colSetting = ColumnSet::make()->textCol([{$getExport}]);
        return ExportResponse::create($colSetting, $data);
    }