package wishlist;

import javax.persistence.*;
import javax.validation.constraints.Min;
import javax.validation.constraints.NotNull;
import lombok.*;
import org.springframework.format.annotation.DateTimeFormat;

import javax.persistence.Id;
import java.util.Date;
import java.util.List;

@Data
@Entity
public class Wish {

    public Wish(){}

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @NotNull
    private String name;

    @NonNull
    @Min(1)
    private Integer count;

    @NotNull
    @DateTimeFormat(pattern = "yyyy-MM-dd")
    @Temporal(TemporalType.TIMESTAMP)
    private Date fordate;

    private String reservedBy;

//    @OneToMany(mappedBy = "wish", cascade = CascadeType.ALL,orphanRemoval = true)
    @OneToMany(mappedBy = "wish", cascade = CascadeType.ALL)
    @ToString.Exclude
    private List<UserWishMapping> userWishMappings;

}
