<?php

class SellerView {
    public static function renderListings($listings) {
        if (empty($listings)) {
            echo "<tr><td colspan='8'>No listings found.</td></tr>";
            return;
        }

        foreach ($listings as $listing) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($listing['title']) . "</td>";
            echo "<td>" . htmlspecialchars($listing['description']) . "</td>";
            echo "<td>" . htmlspecialchars($listing['property_type']) . "</td>";
            echo "<td>$" . number_format($listing['price'], 2) . "</td>";
            echo "<td>" . htmlspecialchars($listing['location']) . "</td>";
            echo "<td>" . htmlspecialchars($listing['status']) . "</td>";
            echo "<td>" . htmlspecialchars($listing['views']) . "</td>";
            echo "<td>" . htmlspecialchars($listing['shortlisted']) . "</td>";
            echo "</tr>";
        }
    }
}