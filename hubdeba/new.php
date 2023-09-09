<!DOCTYPE html>
<html>

<head>
  <!-- Your head content here -->
</head>

<body>
  <!-- Your top content here -->

  <div class="bottom">
    <!-- Other content here -->

    <table>
      <thead>
        <tr>
          <th>Serial No</th>
          <th>Question Name</th>
          <th>PDF Download</th>
          <th>Video Link</th>
          <?php
          if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] > 0) { ?>
            <th>Delete Question</th>
          <?php } ?>
        </tr>
      </thead>
      <tbody>
        <?php
        // Display questions from the database
        if ($result->num_rows > 0) {
          $ser = 1;
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $ser . "</td>";
            $ser++;
            echo "<td>" . $row['question_name'] . "</td>";
            echo "<td><a href='download.php?file=" . urlencode($row['pdf_download']) . "'>Download</a></td>";
            echo "<td><a href='" . $row['video_link'] . "' target='_blank'>Watch</a></td>";

            if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] > 0) {
              echo "<td><a href='delete_question.php?subject=" . urlencode($subject) . "&chapter=" . urlencode($runningChapterNumber) . "&question_name=" . urlencode($row['question_name']) . "' class='delete-link'>Delete</a></td>";
            }

            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='5'>No questions available for this chapter.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</body>

</html>