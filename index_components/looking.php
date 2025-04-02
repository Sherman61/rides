<div id="looking-rides">
    <h2>Looking for a Ride</h2>
    <div class="row">
        <?php
        $hasLookingRides = false;
        $matchingLookingRides = false;
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()): ?>
            <?php if ($row['ride_type'] === 'looking'): ?>
                <?php $hasLookingRides = true; ?>
                <?php if (empty($search) || stripos($row['from_city'], needle: $search) !== false || stripos($row['contact'], $search) !== false): ?>
                    <?php $matchingLookingRides = true; ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">

                                <h5 class="card-title" style="margin-bottom:20px">Looking from
                                    <?php echo htmlspecialchars($row['from_city']); ?>
                                </h5>
                                <p class="card-text"><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
                                <p class="card-text"><strong><i class="fa-regular fa-calendar" aria-hidden="true"></i></strong>
                                    <?php echo htmlspecialchars($row['ride_date']); ?></p>
                                <p class="card-text"><strong><i class="fa fa-clock" aria-hidden="true"></i></strong>
                                    <?php echo $row['ride_time'] ? date('h:i A', strtotime($row['ride_time'])) : 'No Set Time'; ?>
                                </p>

                                <p class="card-text">
                                    <strong><i class="fa fa-phone" aria-hidden="true"
                                            onclick="location.href='tel:<?php echo htmlspecialchars($row['contact']); ?>'"></i>
                                    </strong>
                                    <a href="tel:<?php echo htmlspecialchars($row['contact']); ?>" class="underline">

                                        <?php echo htmlspecialchars($row['contact']); ?>

                                    </a>
                                </p>


                                <?php if (!empty($row['whatsapp'])): ?>
                                    <p class="card-text"><strong> <i class="fa-brands fa-whatsapp text-success"
                                                onclick="contactWhatsApp('<?php echo $row['whatsapp']; ?>')"></i></strong> <a
                                            onclick="contactWhatsApp('<?php echo $row['whatsapp']; ?>')" href="javascript:void(0);">
                                            <?php echo htmlspecialchars($row['whatsapp']); ?>
                                        </a></p>
                                <?php endif; ?>
                                <?php if (!empty($row['memo'])): ?>
                                    <p class="card-text"><strong><i class="fa-solid fa-comment"></i></strong> <?php echo htmlspecialchars($row['memo']); ?></p>
                                <?php endif; ?>

                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning"><i
                                        class="fa-solid fa-pen"></i></a>

                                <a href="#" class="btn btn-danger" onclick="confirmDelete(event, <?php echo $row['id']; ?>)"><i
                                        class="fa-solid fa-trash"></i></a>


                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endwhile; ?>


        <?php if (!$hasLookingRides): ?>
            <div class="col-md-4">
                <p class="text-center card card-title">No one is looking for a ride yet.</p>

            </div>

        <?php elseif (!$matchingLookingRides): ?>
            <div class="col-md-4">
                <p class="text-center card">No matching results for Looking for a Ride.</p>
            </div>
        <?php endif; ?>
    </div>
</div>