 <!-- Filter Dropdown -->
 <div class="mb-3">
            <select id="filter-select" class="form-select">
                <option value="" <?php echo $filter === '' ? 'selected' : ''; ?>>All Rides</option>
                <option value="looking" <?php echo $filter === 'looking' ? 'selected' : ''; ?>>Looking for a Ride</option>
                <option value="offering" <?php echo $filter === 'offering' ? 'selected' : ''; ?>>Offering a Ride</option>
            </select>
        </div>
