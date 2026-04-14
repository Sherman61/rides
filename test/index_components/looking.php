<div id="looking-rides" class="ride-section">
    <h2 class="section-title">Looking for a Ride</h2>
    <div class="row g-3">
        <?php
        $hasLookingRides = false;
        $matchingLookingRides = false;
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()): ?>
            <?php if ($row['ride_type'] === 'looking'): ?>
                <?php $hasLookingRides = true; ?>
                <?php if (empty($search) || stripos($row['from_city'], needle: $search) !== false || stripos($row['contact'], $search) !== false): ?>
                    <?php $matchingLookingRides = true; ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card ride-card h-100 mb-0">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-3">Looking from <?php echo htmlspecialchars($row['from_city']); ?></h5>
                                <p class="card-text"><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
                                <p class="card-text"><strong><i class="fa-regular fa-calendar" aria-hidden="true"></i></strong>
                                    <?php echo htmlspecialchars($row['ride_date']); ?></p>
                                <p class="card-text"><strong><i class="fa fa-clock" aria-hidden="true"></i></strong>
                                    <?php echo $row['ride_time'] ? date('h:i A', strtotime($row['ride_time'])) : 'No Set Time'; ?>
                                </p>

                                <p class="card-text">
                                    <strong><i class="fa fa-phone" aria-hidden="true" onclick="location.href='tel:<?php echo htmlspecialchars($row['contact']); ?>'"></i></strong>
                                    <a href="tel:<?php echo htmlspecialchars($row['contact']); ?>" class="underline"><?php echo htmlspecialchars($row['contact']); ?></a>
                                </p>

                                <?php if (!empty($row['whatsapp'])): ?>
                                    <p class="card-text"><strong><i class="fa-brands fa-whatsapp text-success"
                                                onclick="contactWhatsApp('<?php echo $row['whatsapp']; ?>')"></i></strong> <a
                                            onclick="contactWhatsApp('<?php echo $row['whatsapp']; ?>')" href="javascript:void(0);">
                                            <?php echo htmlspecialchars($row['whatsapp']); ?>
                                        </a></p>
                                <?php endif; ?>

                                <?php if (!empty($row['memo'])): ?>
                                    <p class="card-text"><strong><i class="fa-solid fa-comment"></i></strong> <?php echo htmlspecialchars($row['memo']); ?></p>
                                <?php endif; ?>

                                <div class="mt-auto d-flex gap-2 pt-2">
                                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning action-btn"><i class="fa-solid fa-pen"></i></a>
                                    <a href="#" class="btn btn-danger action-btn" onclick="confirmDelete(event, <?php echo $row['id']; ?>)"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endwhile; ?>

        <?php if (!$hasLookingRides): ?>
            <div class="col-md-6">
                <p class="text-center card card-title empty-state">No one is looking for a ride yet.</p>
            </div>
        <?php elseif (!$matchingLookingRides): ?>
            <div class="col-md-6">
                <p class="text-center card empty-state">No matching results for Looking for a Ride.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
