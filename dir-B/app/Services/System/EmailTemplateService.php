<?php

namespace App\Services\System;

use App\Model\EmailTemplate;
use App\Services\Service;

class EmailTemplateService extends Service
{
    public function __construct(EmailTemplate $emailTemplate)
    {
        parent::__construct($emailTemplate);
    }
    public function getAllData($data, $selectedColumns = [], $pagination = true)
    {
        $query = $this->query()->where('company_id', $data->company_id);

        if (isset($data->keyword) && $data->keyword !== null) {
            $query->where('title', 'LIKE', '%' . $data->keyword . '%');
        }
        if (count($selectedColumns) > 0) {
            $query->select($selectedColumns);
        }
        if ($pagination) {
            return $query->orderBy('id', 'DESC')->paginate(PAGINATE);
        }
        return $query->orderBy('id', 'DESC')->get();
    }

    public function indexPageData($request)
    {
        return ['items' => $this->getAllData($request)];
    }
    public function store($request)
    {
        $emailTemplate = $this->model->create($this->parseRequest($request));
        $emailTemplate->emailTranslations()->createMany($request->get('multilingual'));
        return $emailTemplate;
    }
    public function editPageData($request, $id)
    {
        $email = $this->itemByIdentifier($id);
        return [
            'item' => $email,
        ];
    }
    public function update($request, $id)
    {
        $emailTemplate = $this->itemByIdentifier($request->email_template);
        $emailTemplate->emailTranslations()->delete();
        $emailTemplate = $emailTemplate->update($this->parseRequest($request));
        $emailTemplate = $this->itemByIdentifier($request->email_template);
        $emailTemplate->emailTranslations()->createMany($request->get('multilingual'));
        return $emailTemplate;
    }

    public function parseRequest($request)
    {
        return $request->only('title', 'from');
    }
}
