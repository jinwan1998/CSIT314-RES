<?php
class Property {
    protected $listing_id;
    protected $agent_id;
    protected $title;
    protected $description;
    protected $property_type;
    protected $price;
    protected $location;
    protected $status;
    protected $created_at;
    protected $updated_at;

    public function __construct($listing_id, $agent_id, $title, $description, $property_type, $price, $location, $status, $created_at, $updated_at) {
        $this->listing_id = $listing_id;
        $this->agent_id = $agent_id;
        $this->title = $title;
        $this->description = $description;
        $this->property_type = $property_type;
        $this->price = $price;
        $this->location = $location;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Getter methods
    public function getListingId() {
        return $this->listing_id;
    }

    public function getAgentId() {
        return $this->agent_id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPropertyType() {
        return $this->property_type;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    // Setter methods
    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPropertyType($property_type) {
        $this->property_type = $property_type;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
}
?>