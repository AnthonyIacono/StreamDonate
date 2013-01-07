<?php

class UploadImageResource extends AppResource {
    public function execute() {
        if(!$this->request->post) {
            return new Response(array(
                'status' => '405'
            ));
        }

        $uploader = new ImageUploader($this->request);

        $image_guid = StrLib::Guid();

        if(!isset($_FILES['image']) && !isset($_FILES['qqfile'])) {
            $uploader->put_input_into_files('image');
        }

        $uploader->upload(isset($_FILES['image']) ? 'image' : 'qqfile', $image_guid);

        return new Response(array(
            'body' => json_encode(array(
                'image' => $image_guid
            ))
        ));
    }
}