<div id="offering-rides">
    <h2>Offering a Ride</h2>
    <div class="row">
        <?php
        $hasOfferingRides = false;
        $matchingOfferingRides = false;
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()): ?>
            <?php if ($row['ride_type'] === 'offering'): ?>
                <?php $hasOfferingRides = true; ?>
                <?php if (empty($search) || stripos(haystack: $row['from_city'], needle: $search) !== false || stripos($row['contact'], $search) !== false): ?>
                    <?php $matchingOfferingRides = true; ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title" style="margin-bottom:20px">Offering from
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
                                            class="underline" onclick="contactWhatsApp('<?php echo $row['whatsapp']; ?>')">
                                            <?php echo htmlspecialchars($row['whatsapp']); ?>
                                        </a></p>

                                <?php endif; ?>
                                <?php if (!empty($row['memo'])): ?>
    <p class="card-text"><strong><i class="fa-solid fa-comment"></i></strong> <?php echo htmlspecialchars($row['memo']); ?></p>
<?php endif; ?>

                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning"><i class="fa-solid fa-pen"></i></a>
                                
                                <a href="#" class="btn btn-danger"
                                    onclick="confirmDelete(event, <?php echo $row['id']; ?>)"><i class="fa-solid fa-trash" ></i></a>

                                <!-- <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="#" class="btn btn-danger"
                                    onclick="confirmDelete(event, <?php echo $row['id']; ?>)">Delete</a> -->


                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endwhile; ?>

        <?php if (!$hasOfferingRides): ?>
            <div class="col-md-4 ">
                <p class="text-center card card-title">No rides offered yet.</p>
            </div>
        <?php elseif (!$matchingOfferingRides): ?>
            <p class="text-center ">No matching results for Offering a Ride.</p>
        <?php endif; ?>
    </div>
</div>