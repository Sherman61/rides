<div class="controls-wrap mb-3">
    <label for="filter-select" class="form-label mb-1">Filter rides</label>
    <select id="filter-select" class="form-select">
        <option value="" <?php echo $filter === '' ? 'selected' : ''; ?>>All Rides</option>
        <option value="looking" <?php echo $filter === 'looking' ? 'selected' : ''; ?>>Looking for a Ride</option>
        <option value="offering" <?php echo $filter === 'offering' ? 'selected' : ''; ?>>Offering a Ride</option>
    </select>
</div>
