<?php

namespace FacturationRegie\Traits;

use FacturationRegie\Pointage;

/**
 *
 * for ex : extends task or meeting
 */


trait RegieProject
{
    public function getPointages()
    {
        $pointages = collect();
        foreach (config('facturation-regie.pointable_classes') as $class) {
            $query = Pointage::query();


            $ids = $class::where(config('facturation-regie.pointables_project_foreign_key'), $this->id)->pluck('id');

            $query->whereIn('pointable_id', $ids);
            $query->where('pointable_type', $class);

            //dd(__METHOD__.':'.__LINE__, '$a', $class, $ids);
            if (count($a = $query->get())) {
                $pointages->push($a);
            }
        }
        return $pointages->collapse();
    }
}
